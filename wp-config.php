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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'number1_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         '/THpL)`ym=O/Z|en6-rdtT^1a,#!Xq[gI,McAO:1{uaUnK83-9H!NY7Vk^$k~uzf' );
define( 'SECURE_AUTH_KEY',  ';mh--8!GJVFt6/,r*oLBzqK;92 LBLj^zp_9ld7je?cc^e)Q?3-PDolmr=)LF`]Y' );
define( 'LOGGED_IN_KEY',    '%}herYI-JqwEpEN2u}~hZx0s/agYm]tbIVPQ7.u&X5a:J@?SE2If]O{!DMQ$R*;/' );
define( 'NONCE_KEY',        ',]ykiu)nHngp/BSdB{L}w)=@<nq&NHO@}]SqO@2&V,.rW2EG{QpDo:lH;$j)gDFl' );
define( 'AUTH_SALT',        'n-KeYsEul!RyYjJQ1bsM7S0.rc3sO6F9XT*!GH<o}nP-`Da(%+CK(+Gu[O>|[o5f' );
define( 'SECURE_AUTH_SALT', '~JZM:+4rjeW NQE3,h#kP7~w sJ=VjD/2 Qu4H>U?C0E#WBtQBP+8]-Jqe:KI^IW' );
define( 'LOGGED_IN_SALT',   'Xs2./xcw7PzK[]V{>Mu;{KB1q0wmq:+w2EcaW4^/KLs _XXkOKMWUP77;p..H$ma' );
define( 'NONCE_SALT',       'XG$dR83`00uBlbB*4_FWFHi7d;4s84~&vk0>zo^qdy<}P)wl|$CrJ,$e2X4h|gm|' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
