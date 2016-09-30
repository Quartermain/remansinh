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
define('DB_NAME', 'remansinh');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '*%fG=viAyhmDtZHCLBFQypT2p8?19-y38]0caIsk?+oh<tyxdkAqh6?f$[6GnpQF');
define('SECURE_AUTH_KEY',  'R5i}3mBYsjZ4`yq<nUUHrlJj O@[{qkYf&F>?.4?^BQ33cl{q?M12x_PSk;2CQ;7');
define('LOGGED_IN_KEY',    '(TZ+g([{RsL5rl3x~bt5JdH.<Akk(=f>vRF]4pdPOuiw`5c_D*+%cNqc)Fl;?P5;');
define('NONCE_KEY',        's1&lU{nz5Ion3^:vlGul8%dGF*gyeeHa^R3eQU^.!vNI7c1u_^^HBK)nux|$V/ q');
define('AUTH_SALT',        '=D@^R=z!qDiw>^e6qX=3KzPEi*U>L6UT}a047lre::SQPiapgPpA<yjy+)k~ipB6');
define('SECURE_AUTH_SALT', '47xM[7{&&6=vr;*FwJW>Ht{.McG63xV9H3.fX ,Ofo>sA~8^_WDDxf-^[`L$t#h{');
define('LOGGED_IN_SALT',   '<@(fYryN0nC%@V~Zc!jy;KfVq]7g,xzdG0;#k-HKLBG1V=>nI%>*SOq:>XPsBQW~');
define('NONCE_SALT',       'Uh.hFz=Q#KpX`qa,h1*};uMLKP}[g#}.#Fc(9F<<PL%X$53=cy_puv.bbLija):h');

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
