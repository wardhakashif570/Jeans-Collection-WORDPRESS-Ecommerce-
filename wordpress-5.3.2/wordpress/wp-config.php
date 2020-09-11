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
define( 'DB_NAME', 'testsite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|A?;V;PjyN3AXTS%=ce12?`Ly:e`,%svIyG#*Zf23.+0_n9Mme/PiIaJ(C(E:n#=' );
define( 'SECURE_AUTH_KEY',  'Zp8hW+!{u}%]n>I#*ooS7>7Uz?m+VVT1Yi>1sR<({+b)w;EzsQZAFR}`=[cUYs}^' );
define( 'LOGGED_IN_KEY',    '_fz_X&J+sTQIy5^?_lgmasOR5iT$T{>iPv(c4(>OChE3O[S{08bz@?A^I ur*#C|' );
define( 'NONCE_KEY',        '<N7!@9*S9%0gOd5xGWALg&0O0NGl~5bjg m!,mlPd<].!.{#AKl9d#HLwIg987y+' );
define( 'AUTH_SALT',        'ajD`dr(IR?JjkB>Xm(sT+4HmNin= +5^EYCBW~wBN.FQB..8p2IzLpaaR&2B#=Uk' );
define( 'SECURE_AUTH_SALT', 'RGR_HHeQu=dq>Rzctm_;aUdI[Ml+DZ$a0.]%J8?j@6Mc$g 1v@X+D$H{+w(PbXYJ' );
define( 'LOGGED_IN_SALT',   '*{:kQDnzPXgx~gG.281^N5ITML=3jS*H2.JP@@Gb$|gSb&]N7G}N.,^;:8j|2SLx' );
define( 'NONCE_SALT',       'T(^N]:3q}dnq;I~Hjk%HI9:mYZr0qFNAL=Bp>%d!;(V q;uu-S6}^V%X{RD<921 ' );

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
