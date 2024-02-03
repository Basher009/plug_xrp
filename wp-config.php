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
define( 'DB_NAME', 'plug_xrp' );

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
define( 'AUTH_KEY',         'PID_4ORzW;khxg6&5#08 vVA>9T$0ZgibD:N_h8s]$%lnGI<+E+-_%u#_{@COxSX' );
define( 'SECURE_AUTH_KEY',  '=H`fC=q>csN1]Ud_ka]K!f/}%%{UjP|{SYNwT^~w9|~C=Lbz:Fza4.S^Y(zH(@T*' );
define( 'LOGGED_IN_KEY',    'g|00@Hg=sh}X (p?GJbFC<~ssj3`V.(B;H, [+Ey#e5x# :9$<(UG,-baIz,/C.l' );
define( 'NONCE_KEY',        'q1 MFISQcibl&wW.c^Ld.Gg9mR%{H?S6opyGrQFjO|{Tj5gi($EG(5:nUAYhT5v%' );
define( 'AUTH_SALT',        'DIO#6:=Bhc(Zv4&%H>F(^5IkG<>z9WXmL8(:~(;vVJYh0=!~rmY]Q&I?Omc%z>5/' );
define( 'SECURE_AUTH_SALT', '>/c(68@p80:=FAQGO*S-C7bjLWR<}kch`=Y-Hp?R-mO@j@@v.tf.RN+c:_&o@<J&' );
define( 'LOGGED_IN_SALT',   ':mD21b*uP~a+2uyD#N,BCQ.G/#X[KE;mZ,eTE2]|qiM&fgG?A@RjWeq!}*IB>Bhx' );
define( 'NONCE_SALT',       '&|Wn*l+$mCd5Qn,AkcMLRdruj?=SCLN$BIfHI>ly<S?h9n`E`At~M>EPScwX{iQD' );

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
