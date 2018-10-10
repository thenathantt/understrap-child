<?php /* BEGIN KINSTA STAGING ENVIRONMENT */ ?>
<?php if ( !defined('KINSTA_DEV_ENV') ) { define('KINSTA_DEV_ENV', true); /* Kinsta staging - don't remove this line */ } ?>
<?php if ( !defined('JETPACK_STAGING_MODE') ) { define('JETPACK_STAGING_MODE', true); /* Kinsta staging - don't remove this line */ } ?>
<?php /* END KINSTA STAGING ENVIRONMENT */ ?>
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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'finleyjewelry' );

/** MySQL database username */
define( 'DB_USER', 'finleyjewelry' );

/** MySQL database password */
define( 'DB_PASSWORD', '4eJv8X1VemxcG1U' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~sA !MuaCYi9MESrCo+Y:lzbH][%m*U|oI,AMb?S,2<83XISu Yz&[ipi(k]KYCD' );
define('SECURE_AUTH_KEY',  'QVgDU|GktlL!]p0`KVYQb!#].=Z7z>$|`/4cEN~HT;z;RS0lbBF|P&8F[^ES~$b=');
define('LOGGED_IN_KEY',    'cSE|w3waUuO+OS)TZ8K&sYhzYN*aW>-U{.%G&#P`[8g8a-{-y909,NeMl*/}1HV ');
define('NONCE_KEY',        'Cf|x*mh{rG@zayO>e$`A<4ekgNHIJ}L){p-HH.U_JxldIB1-2O+c5|&G_//--h4j');
define( 'AUTH_SALT',        'nkb,pHy92B2NsoM,oxCl%UU_GG,y&I7>T|JR``Jfp,h8mofYf1kI^c6s<GMZI6<@' );
define('SECURE_AUTH_SALT', ';M!3OK/A$>2h`QKH2mjD0gAi4QYEq3bu.9Gll{VgP`hh/=yz:NYg+cZzG$ZG,bdx');
define('LOGGED_IN_SALT',   'T)+]p+_53%x0LEy9:t0,N9~|/LS!w-&vHXOA5b!u3l%KD k:|>N:E]pIuv@^Vmv=');
define('NONCE_SALT',       '^o+E4%TTW-+6cpXr=5rVE3*|NS_tgYk:G)~o^v,}fUR`-fu<rjA%<vV+o!XydArc');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

@ini_set('log_errors', 'On');
@ini_set('error_log', '/www/finleyjewelry_404/public/php-errors.log');


define('WP_CACHE', true); // Added by WP Rocket
define('WP_MEMORY_LIMIT', '512M');
define('DISABLE_NAG_NOTICES', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
