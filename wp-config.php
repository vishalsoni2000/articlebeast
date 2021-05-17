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
define( 'DB_NAME', '' );

/** MySQL database username */
define( 'DB_USER', '' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', '' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'WP_DEBUG', false );

//define('WP_SCSS_ALWAYS_RECOMPILE', true);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?=!`TcfC@o<EZ!QKuqH{I{HO~}$XcTSt`Fl?1],wDyS%._%4dK<uE%Pld&+XO,Gm' );
define( 'SECURE_AUTH_KEY',  'UbnV^k[kg_^TWCU2cQlJ,wpdaH[lJ5(#P8tkOM?IjZ=S/j&jf9*y(I~*wjnRU-=N' );
define( 'LOGGED_IN_KEY',    'wE8ecNd*z>fiAv5}EaRknoD:NMnoa*swZ%<:WH ?8A6<o3*Sh>QC|RE NapOw3`T' );
define( 'NONCE_KEY',        'O$zoiYEL>CyTrB-WhP6ITP~XM4yx}2+H+SKN|c/TU0[JyPxHn>n1L9FfgB`ExJ(+' );
define( 'AUTH_SALT',        'r^2&Q!S+,qLuUPLUv WN,Refw8%W@JZ^3FB.b0!e3C=Sf7H7!?v)kyBe,SAE3-77' );
define( 'SECURE_AUTH_SALT', '4+QZ(JDc-#j/3[aL!9}zkvMBv&Z&V960MqWw_0_^Z~M|yrgSC2TIC:qJ:)#VLA|N' );
define( 'LOGGED_IN_SALT',   'p5!5XzX=#1x111@SV {QG`sc`;l%S+Pn6&V%Jm?1urA>H<;EjX4Qx^=B-=p:C~sH' );
define( 'NONCE_SALT',       'J};ApiHNEl<nV(no)<l>c`)a$}M*Gzm>L0G-Wl->5P9D-+<_<c$^~&{T5KRqp(1/' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
