<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cyclongr' );

/** Database username */
define( 'DB_USER', 'cyclongr' );

/** Database password */
define( 'DB_PASSWORD', 'M2wJI0ptcpcCnmQ' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
// define( 'DISALLOW_FILE_EDIT', true );
// define( 'DISALLOW_FILE_MODS', true );
//


/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'Oj/.hN->FocQ*Au(H),/D|1CVL`bW5z0<?mH(LX[W(lD#D.W@*AD4-9)aqKZ^bju' );
define( 'SECURE_AUTH_KEY',   'ECNhJQ^/.aV`#<cr]YiMNaY6DO-/+[sEx_0Hg^&Sc*m;z]d/SI[^bt~j*N3K;zuI' );
define( 'LOGGED_IN_KEY',     '~Q}Ot%ffLwBx[3*&V(Ozy1(h>:vd`@;W2v>:8zznC$./}}5lm?j!C3XXjx&dDeYr' );
define( 'NONCE_KEY',         '#6>!Z;u_o)aXW*zbK94qGy@oT}O{B+&6tT=Vs6mJU3GdX=v.v7-,Z#Uj`Uw:%9pU' );
define( 'AUTH_SALT',         'Z+]1+$>&LeOxVvy*g[{/y7wyq3P.y,qCpW^XR+NST]^}aC82t;JpIYP3MBc!}ct&' );
define( 'SECURE_AUTH_SALT',  'q.],;Pux$<hHieNP~t)i!HnVI6Lno;B0z@F1!!Mn=&a5r2zZvY/E[(A&euZ@M[3j' );
define( 'LOGGED_IN_SALT',    ':S|y[E{t79eID{?-}bIs%D=e.iM6$r|?|R5<FxT)tk8XZPp 7%.<!~BiOxAw=[ ]' );
define( 'NONCE_SALT',        'rcF@%+%(W>o@la^QlmB:U-Em1R|vXD`~#I2dpiS^d$pqE>pcC/N4^i--7,c:):s;' );
define( 'WP_CACHE_KEY_SALT', 'gnlE(](D+%eD_T`4F-iMTaR/&WIp_~LRROh@_]dtR;{3yMEUEM$YBqtoE*bm9T<N' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'gAkEoW_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
