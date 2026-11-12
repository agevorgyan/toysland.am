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
define( 'DB_NAME', 'toysland_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'db{WUiCNDNZwF]1K}_Qy>Jr#Am}#-aZR(m*6_edV/:g576XDuuCTk *E(,ASv(Fv' );
define( 'SECURE_AUTH_KEY',   'nL82LpmI!&%/DaUAp)[%nb0Wd$q~bUZ1MZ~{t(N28ltmE<MB$x-`/,i*P.q^e-pO' );
define( 'LOGGED_IN_KEY',     'YE=y^@9?91hEdD;K{HLJ 5otp7bmRgGR(k=Q4>9^<FanNQlXT;vF=0Ylz)jJV@FI' );
define( 'NONCE_KEY',         'tU~mqxHjSm`)}1Tj8BB>,+n[$v2`^+?85.Ipo5FjD~*#0Sj`rxEhX;R=Kk?~y@)f' );
define( 'AUTH_SALT',         '{N~Yx2]Ix:sraKuprJS}#IceMr&Om97!f]99d+5L;DK`1OQEcgIW]r0((@B<:Y1k' );
define( 'SECURE_AUTH_SALT',  ',i/%)Ag:~R(:w;^BCbbXUP1&sac<BwP%ymH9[ei~y=O|1ttwJ<^h+^G}gT(/4&!&' );
define( 'LOGGED_IN_SALT',    '}Jw8!X[RtXrG)qLyarb3mZe,Un)jUPBba2g*,%L8,kKD:~z)wUXdalJcqMbr>Zhz' );
define( 'NONCE_SALT',        'fny9_Q71QCWZ&k*(;]O)w|ZaUG)*T)L1?C0!rx~(4xvC1xn/1g40MF_PtPnPg215' );
define( 'WP_CACHE_KEY_SALT', '4Mk&JtAkIl$ycNa ln~MFgCwKK$9kU$J5S3aOsq&jH@2107fZIq[iquZ9SU/lNEP' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
