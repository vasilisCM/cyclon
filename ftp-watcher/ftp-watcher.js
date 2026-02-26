const fs = require('fs');
const path = require('path');
const chokidar = require('chokidar');
const { minimatch } = require('minimatch');

// Load configuration
const configPath = path.join(__dirname, 'ftp-config.json');
let config;

try {
  config = JSON.parse(fs.readFileSync(configPath, 'utf8'));
  console.log(`✓ Configuration loaded: ${config.name}`);
} catch (error) {
  console.error('❌ Error loading ftp-config.json:', error.message);
  process.exit(1);
}

// Set working directory to localPath
const localPath = path.resolve(__dirname, config.localPath || './');
try {
  process.chdir(localPath);
  console.log(`✓ Working directory: ${localPath}`);
} catch (error) {
  console.error(`❌ Cannot access local path: ${localPath}`, error.message);
  process.exit(1);
}

// Determine protocol and load appropriate client
let client;
let Client;

if (config.protocol === 'sftp') {
  Client = require('ssh2-sftp-client');
  client = new Client();
} else if (config.protocol === 'ftp') {
  const { Client: FtpClient } = require('basic-ftp');
  client = new FtpClient();
} else {
  console.error('❌ Unsupported protocol. Use "ftp" or "sftp"');
  process.exit(1);
}

// Connection state
let isConnected = false;
let reconnectTimer = null;

// Upload queue to prevent concurrent operations
let uploadQueue = [];
let isProcessingQueue = false;

// Check if file should be ignored
function shouldIgnore(filePath) {
  const relativePath = path.relative(process.cwd(), filePath);
  const normalizedPath = '/' + relativePath.replace(/\\/g, '/');
  
  if (config.ignore && Array.isArray(config.ignore)) {
    for (const pattern of config.ignore) {
      if (minimatch(normalizedPath, pattern, { dot: true }) || 
          minimatch(relativePath, pattern.replace(/^\//, ''), { dot: true })) {
        return true;
      }
    }
  }
  return false;
}

// Connect to server
async function connect() {
  try {
    console.log(`\n🔄 Connecting to ${config.protocol.toUpperCase()} server...`);
    
    if (config.protocol === 'sftp') {
      await client.connect({
        host: config.host,
        port: config.port || 22,
        username: config.username,
        password: config.password
      });
    } else {
      await client.access({
        host: config.host,
        port: config.port || 21,
        user: config.username,
        password: config.password,
        secure: config.secure || false,
        secureOptions: { rejectUnauthorized: false }
      });
    }
    
    isConnected = true;
    console.log(`✓ Connected to ${config.host}`);
    console.log(`✓ Remote path: ${config.remotePath}`);
    console.log(`✓ Watching for changes...\n`);
    
  } catch (error) {
    console.error('❌ Connection failed:', error.message);
    isConnected = false;
    scheduleReconnect();
  }
}

// Schedule reconnection
function scheduleReconnect() {
  if (reconnectTimer) return;
  
  console.log('⏳ Reconnecting in 5 seconds...');
  reconnectTimer = setTimeout(() => {
    reconnectTimer = null;
    connect();
  }, 5000);
}

// Process upload queue
async function processQueue() {
  if (isProcessingQueue || uploadQueue.length === 0) {
    return;
  }

  isProcessingQueue = true;

  while (uploadQueue.length > 0) {
    const task = uploadQueue.shift();
    
    try {
      if (task.type === 'upload') {
        await uploadFileImmediate(task.path);
      } else if (task.type === 'delete') {
        await deleteFileImmediate(task.path);
      } else if (task.type === 'rename') {
        await renameFileImmediate(task.oldPath, task.newPath);
      }
    } catch (error) {
      console.error(`❌ Queue task failed:`, error.message);
    }

    // Small delay between operations
    await new Promise(resolve => setTimeout(resolve, 50));
  }

  isProcessingQueue = false;
}

// Add to queue
function queueUpload(filePath) {
  // Remove duplicates for the same file
  uploadQueue = uploadQueue.filter(task => 
    !(task.type === 'upload' && task.path === filePath)
  );
  uploadQueue.push({ type: 'upload', path: filePath });
  processQueue();
}

function queueDelete(filePath) {
  uploadQueue = uploadQueue.filter(task => 
    !(task.type === 'delete' && task.path === filePath)
  );
  uploadQueue.push({ type: 'delete', path: filePath });
  processQueue();
}

function queueRename(oldPath, newPath) {
  uploadQueue.push({ type: 'rename', oldPath, newPath });
  processQueue();
}

// Upload file (immediate execution, called from queue)
async function uploadFileImmediate(localPath) {
  if (!isConnected) {
    console.log(`⏸️  Not connected. Skipping: ${localPath}`);
    return;
  }

  if (shouldIgnore(localPath)) {
    return;
  }

  try {
    const relativePath = path.relative(process.cwd(), localPath);
    const remotePath = path.posix.join(config.remotePath, relativePath.replace(/\\/g, '/'));
    
    // Ensure remote directory exists
    const remoteDir = path.posix.dirname(remotePath);
    
    if (config.protocol === 'sftp') {
      await client.mkdir(remoteDir, true);
      await client.put(localPath, remotePath);
    } else {
      // For FTP, ensure directory exists
      await ensureRemoteDir(remoteDir);
      await client.uploadFrom(localPath, remotePath);
    }
    
    const timestamp = new Date().toLocaleTimeString();
    console.log(`✓ [${timestamp}] Uploaded: ${relativePath}`);
    
  } catch (error) {
    console.error(`❌ Upload failed for ${localPath}:`, error.message);
    
    // If connection error, try to reconnect
    if (error.message.includes('connect') || error.message.includes('timeout') || error.message.includes('closed')) {
      isConnected = false;
      scheduleReconnect();
    }
  }
}

// Upload file (adds to queue)
function uploadFile(localPath) {
  queueUpload(localPath);
}

// Ensure remote directory exists (for FTP)
async function ensureRemoteDir(dirPath) {
  if (config.protocol !== 'ftp') return;
  
  try {
    await client.ensureDir(dirPath);
  } catch (error) {
    // Ignore errors, directory might already exist
  }
}

// Delete file (immediate execution, called from queue)
async function deleteFileImmediate(localPath) {
  if (!isConnected) {
    console.log(`⏸️  Not connected. Skipping delete: ${localPath}`);
    return;
  }

  if (shouldIgnore(localPath)) {
    return;
  }

  if (!config.watcher?.autoDelete) {
    return;
  }

  try {
    const relativePath = path.relative(process.cwd(), localPath);
    const remotePath = path.posix.join(config.remotePath, relativePath.replace(/\\/g, '/'));
    
    if (config.protocol === 'sftp') {
      await client.delete(remotePath);
    } else {
      await client.remove(remotePath);
    }
    
    const timestamp = new Date().toLocaleTimeString();
    console.log(`🗑️  [${timestamp}] Deleted: ${relativePath}`);
    
  } catch (error) {
    // Ignore errors if file doesn't exist on remote
    if (!error.message.includes('No such file')) {
      console.error(`❌ Delete failed for ${localPath}:`, error.message);
    }
  }
}

// Delete file (adds to queue)
function deleteFile(localPath) {
  queueDelete(localPath);
}

// Rename/Move file (immediate execution, called from queue)
async function renameFileImmediate(oldLocalPath, newLocalPath) {
  if (!isConnected) {
    console.log(`⏸️  Not connected. Skipping rename: ${oldLocalPath} -> ${newLocalPath}`);
    return;
  }

  if (shouldIgnore(oldLocalPath) && shouldIgnore(newLocalPath)) {
    return;
  }

  try {
    const oldRelativePath = path.relative(process.cwd(), oldLocalPath);
    const newRelativePath = path.relative(process.cwd(), newLocalPath);
    
    const oldRemotePath = path.posix.join(config.remotePath, oldRelativePath.replace(/\\/g, '/'));
    const newRemotePath = path.posix.join(config.remotePath, newRelativePath.replace(/\\/g, '/'));
    
    // Ensure destination directory exists
    const newRemoteDir = path.posix.dirname(newRemotePath);
    
    if (config.protocol === 'sftp') {
      await client.mkdir(newRemoteDir, true);
      await client.rename(oldRemotePath, newRemotePath);
    } else {
      await ensureRemoteDir(newRemoteDir);
      await client.rename(oldRemotePath, newRemotePath);
    }
    
    const timestamp = new Date().toLocaleTimeString();
    console.log(`📝 [${timestamp}] Renamed: ${oldRelativePath} -> ${newRelativePath}`);
    
  } catch (error) {
    console.error(`❌ Rename failed:`, error.message);
    
    // Fallback: delete old and upload new
    console.log(`   Falling back to delete + upload...`);
    await deleteFileImmediate(oldLocalPath);
    await uploadFileImmediate(newLocalPath);
  }
}

// Rename file (adds to queue)
function renameFile(oldPath, newPath) {
  queueRename(oldPath, newPath);
}

// Initialize watcher
function initWatcher() {
  const watchPattern = config.watcher?.files || '**/*';
  
  const watcher = chokidar.watch(watchPattern, {
    ignored: /(^|[\/\\])\../, // ignore dotfiles
    persistent: true,
    ignoreInitial: true,
    awaitWriteFinish: {
      stabilityThreshold: 500,
      pollInterval: 100
    }
  });

  watcher
    .on('add', filePath => {
      if (config.watcher?.autoUpload) {
        uploadFile(filePath);
      }
    })
    .on('change', filePath => {
      if (config.uploadOnSave || config.watcher?.autoUpload) {
        uploadFile(filePath);
      }
    })
    .on('unlink', filePath => {
      if (config.watcher?.autoDelete) {
        deleteFile(filePath);
      }
    })
    .on('addDir', dirPath => {
      // Directories are created automatically when uploading files
    })
    .on('unlinkDir', dirPath => {
      // Optional: handle directory deletion if needed
    })
    .on('error', error => {
      console.error('❌ Watcher error:', error);
    });

  console.log(`👁️  File watcher initialized`);
  console.log(`📂 Watching pattern: ${watchPattern}`);
  console.log(`ℹ️  Note: File renames are handled as delete + upload`);
  if (config.ignore) {
    console.log(`🚫 Ignoring: ${config.ignore.join(', ')}`);
  }
}

// Handle graceful shutdown
process.on('SIGINT', async () => {
  console.log('\n\n🛑 Shutting down...');
  
  try {
    if (isConnected) {
      if (config.protocol === 'sftp') {
        await client.end();
      } else {
        client.close();
      }
      console.log('✓ Connection closed');
    }
  } catch (error) {
    console.error('Error closing connection:', error.message);
  }
  
  process.exit(0);
});

// Start the application
async function start() {
  console.log('═══════════════════════════════════════════');
  console.log(`  ${config.protocol.toUpperCase()} File Watcher`);
  console.log('═══════════════════════════════════════════');
  
  await connect();
  initWatcher();
}

start();