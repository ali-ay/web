<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'new-iyzico-wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:8889');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@%f/$V(I)af?j~Ek_ !:.G)<Lg)qkGoU!nb^w<heZb9mX6-MY*Bw@EoH/}tWQ9fc');
define('SECURE_AUTH_KEY',  ')0J@|2S{v4_lQ||J&ohe(-E<dR|<o1.tCLl4);:vH$Fws-h~lA_xGy%OU,5(mwwB');
define('LOGGED_IN_KEY',    ';tl+g0S?g&o.P0]SQ WW.)Z8L)c*.:f40V//78%dK,S=egiWz]<+%|wItS):=Yhe');
define('NONCE_KEY',        'MbvDJbmV*bCQ54-Txug 2#&<>rU!9AHT|% `r8qLSx0U6x%Kert6mlB-l)U.6!P6');
define('AUTH_SALT',        '<v`#T%EED9=`s?b2$wa2.M7b|cq6y7[`]=jO2$eC #At11ewiM;[IjY mm%tf w~');
define('SECURE_AUTH_SALT', '+ZLQW)Q[U_YNHnbBC*/s1F,m,Ef}}G3=C*Mxmb%0|*vJEI:[sRNC}?a~7q5e5y1h');
define('LOGGED_IN_SALT',   '*x`5JzoWIWT$]=3DuFHh0L-`@hHc=nY9ijVngb@h8y-&!i GxVdl_2V#!lfXLw:`');
define('NONCE_SALT',       '-}C-H,5]pn*nCi>MKxd-FJ4/2/YBd-S rbU|(u7-{mh2]E@P b!;,qP>$!2ypXK9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
