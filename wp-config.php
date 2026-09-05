<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'syuhada' );

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
define( 'AUTH_KEY',         'HH>:b*8kw-vdMFE|5[/MsZ[siG)2peM%fvkMI! )xenncPXAAsMTYE=l]7.X6;Fm' );
define( 'SECURE_AUTH_KEY',  '7X]i?w-<HU4&o*n_l1lYbST>:(Tq>MTaAZ*,_I|HF!^r]nY.Xm8*eXyz&0~r+b?v' );
define( 'LOGGED_IN_KEY',    ';8[<]6sa`p/nXE1r:~@[dCuMh=k:*UYM`H$,ah*%yK5uZM}[}n2PCEL}5]n,^e{b' );
define( 'NONCE_KEY',        'Tws:66AXY0Sm:>6[nRNS2@5b{rh>Z ULb0@*F?w5m$I&$~~|Jmr5C4eBoZ?6.XMv' );
define( 'AUTH_SALT',        'jnD {Ua;C5na=MQm36|LqJ1tZVA:R -=*aQ3 9$~{k_-d;vrmk8tJ7[-]DqxU+}-' );
define( 'SECURE_AUTH_SALT', 'F(x`ib>{LdXHvj(FGUqn}mZ4qCVx== F<-KQJ;f=2H .VsfzAVdXSJGQiH0a>z<V' );
define( 'LOGGED_IN_SALT',   'YL<[W_yO]nm4jHjL%m&1x5UDlqFSjJF$X.B+uUG2<H+=/P30US03&I7.@Lv7]ul/' );
define( 'NONCE_SALT',       'tX1xR%cjxyU #OLRga?4.i9cTI`!TE@u9xEWZ8Se|7)x-5N}!~F`P,|wjxCf[*:5' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
