# FTP/SFTP File Watcher

Automatically upload files to an FTP or SFTP server when they change locally.

## Features

- ✅ Support for both FTP and SFTP protocols
- 🔄 Auto-upload on file save
- 🗑️ Auto-delete remote files when local files are deleted
- 📝 File renames tracked (handled as delete old + upload new)
- 👁️ Real-time file watching with debouncing
- 🔌 Automatic reconnection on connection loss
- 🚫 Configurable ignore patterns
- 📦 Easy configuration via JSON

## Installation

```bash
npm install
```

## Setup for Existing VS Code Projects

You have **two options** to use this with your existing WordPress theme or PHP project:

### Option 1: Place files in your project root (Recommended)

1. Copy all files (`package.json`, `ftp-watcher.js`, `ftp-config.json`, `.gitignore`) to your WordPress theme directory
2. In `ftp-config.json`, set:
   ```json
   "localPath": "./",
   ```
3. Run `npm install` in your theme directory
4. Run `npm run ftp`

**Example structure:**
```
my-wordpress-theme/
├── style.css
├── index.php
├── functions.php
├── package.json          ← Add this
├── ftp-watcher.js        ← Add this
├── ftp-config.json       ← Add this
└── .gitignore            ← Add this
```

### Option 2: Place files outside and point to your project

1. Create a separate folder (e.g., `ftp-sync/`) anywhere on your computer
2. Place all files there
3. In `ftp-config.json`, set `localPath` to your theme directory:
   ```json
   "localPath": "../my-wordpress-theme",
   // or absolute path:
   "localPath": "/Users/yourname/projects/my-wordpress-theme",
   ```
4. Run `npm install` in the `ftp-sync/` folder
5. Run `npm run ftp`

**Example structure:**
```
projects/
├── ftp-sync/
│   ├── package.json
│   ├── ftp-watcher.js
│   ├── ftp-config.json
│   └── .gitignore
└── my-wordpress-theme/   ← Watches this
    ├── style.css
    ├── index.php
    └── functions.php
```

### Which option to choose?

- **Option 1**: Simpler, keeps everything together, easier to manage
- **Option 2**: Keeps FTP files separate, useful if you sync multiple projects

## Configuration

Edit `ftp-config.json` to match your server settings:

```json
{
  "name": "Staging Server",
  "host": "155.330.487.22",
  "protocol": "ftp",          // "ftp" or "sftp"
  "port": 21,                 // 21 for FTP, 22 for SFTP
  "username": "myftp_staging",
  "password": "D213^^&8u370h",
  "localPath": "./",          // Local directory to watch (relative to this script or absolute)
  "remotePath": "/httpdocs/wp-content/themes/cyclon",
  "uploadOnSave": true,
  "syncMode": "update",
  "watcher": {
    "files": "**/*",          // Glob pattern for files to watch
    "autoUpload": true,       // Auto-upload on change
    "autoDelete": true        // Auto-delete on local file deletion
  },
  "ignore": [
    "/node_modules",
    "/node_modules/**",
    "/.git",
    "/.git/**",
    "/ftp-watcher.js",
    "/ftp-config.json",
    "/package.json",
    "/package-lock.json"
  ]
}
```

### Configuration Options

- **name**: Friendly name for the connection
- **host**: Server hostname or IP address
- **protocol**: `"ftp"` or `"sftp"`
- **port**: Port number (21 for FTP, 22 for SFTP)
- **username**: FTP/SFTP username
- **password**: FTP/SFTP password
- **localPath**: Local directory to watch - can be relative (`./`, `../my-theme`) or absolute (`/path/to/theme`)
- **remotePath**: Remote directory path where files will be uploaded
- **uploadOnSave**: Enable automatic upload when files change
- **watcher.files**: Glob pattern for files to watch (e.g., `"**/*"` for all files)
- **watcher.autoUpload**: Auto-upload changed files
- **watcher.autoDelete**: Auto-delete remote files when local files are deleted
- **ignore**: Array of glob patterns to ignore

## Usage

Start the watcher:

```bash
npm run ftp
```

The script will:
1. Connect to your FTP/SFTP server
2. Start watching for file changes in the current directory
3. Automatically upload modified files to the remote path
4. Optionally delete remote files when local files are deleted

Press `Ctrl+C` to stop the watcher.

## Example Output

```
═══════════════════════════════════════════
  FTP File Watcher
═══════════════════════════════════════════
✓ Configuration loaded: Staging Server
✓ Working directory: /Users/yourname/projects/my-wordpress-theme

🔄 Connecting to FTP server...
✓ Connected to 155.330.487.22
✓ Remote path: /httpdocs/wp-content/themes/cyclon
✓ Watching for changes...

👁️  File watcher initialized
📂 Watching pattern: **/*
ℹ️  Note: File renames are handled as delete + upload
🚫 Ignoring: /node_modules, /node_modules/**, /.git, /.git/**

✓ [14:32:15] Uploaded: style.css
✓ [14:32:18] Uploaded: index.php
🗑️  [14:32:22] Deleted: old-file.js
```

## Troubleshooting

### Connection Issues
- Verify your host, username, and password
- Check that the port is correct (21 for FTP, 22 for SFTP)
- Ensure your firewall allows connections

### Files Not Uploading
- Check the `ignore` patterns in your config
- Verify the `watcher.autoUpload` is set to `true`
- Check console for error messages

### Permission Errors
- Ensure your FTP/SFTP user has write permissions to the `remotePath`
- Verify the remote path exists or the user can create it

## Notes

- Files are uploaded with a 500ms debounce to avoid multiple uploads during rapid saves
- The script automatically reconnects if the connection is lost
- Hidden files (starting with `.`) are ignored by default
- **File renames/moves**: When you rename or move a file, it's detected as a delete + add event, so the old file is deleted from the server and the new file is uploaded. The `renameFile()` function is available for future FTP/SFTP protocol optimizations.
- Make sure to add `ftp-config.json` to `.gitignore` to avoid committing credentials

## Security

⚠️ **Important**: Never commit `ftp-config.json` with real credentials to version control!

Add to your `.gitignore`:
```
ftp-config.json
```

Consider using environment variables for sensitive data in production.
