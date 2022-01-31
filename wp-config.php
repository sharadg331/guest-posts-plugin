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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mdot' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'A.T$Hw(w]4g^9qhRX010z2>j@P(Aj&SYj>s8?##qn-/iAd@F5]G(ov1Qe,b]`w3j' );
define( 'SECURE_AUTH_KEY',  'rRvVV!,Y_TEImE)aj>_pcr(AswW.,gm[_LEe[~>&Jr3;:*FtI(sDosPvcbN1ie`=' );
define( 'LOGGED_IN_KEY',    'o|L`3U9DJn{juRSf7nw8O9CoDh/4/IL|{^:4qQj?*aa5PhEWAttVS2^bx&$2Vmz^' );
define( 'NONCE_KEY',        '[;d|09mIRdND}fxe(>7$[sYn{p|Vw+pp_?T} ,2^idUpodzPUttXvHE]cz{7L,~j' );
define( 'AUTH_SALT',        ',MXTA^S)/5hh?YVOXAv:=R3u@tkR^PuF U6(&*br5Wa;ezK6*U`GVZ<uvAi YUO$' );
define( 'SECURE_AUTH_SALT', 'C%Bpg0t-eKmU)Y1Eov $?rC)}e^d d;1<rFa%uqyGhm2H$V4lwd4g~o$b@1hyi%P' );
define( 'LOGGED_IN_SALT',   'U/4VzKK G3vH6kbFEb0 /?glI@UXpv3~(*wEnRYIC;4@)yGr^)|jd_fN:fSK}(K$' );
define( 'NONCE_SALT',       'CDA%&`_4>@(DiPq)b~S;8Uz)>PoQU+jl-o(X9Wy4#PqfYebnJyaRDz7_7+DN;NO7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'md_';

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
