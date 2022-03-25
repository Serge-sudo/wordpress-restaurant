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
define('DB_NAME', 'final');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Of-U]<Qu0db.sZDmaF#8uf%bQNBca+/IdE>e=LI=x}]Hn4ynCG|)fdwG$aV<?BdX');
define('SECURE_AUTH_KEY',  'N#2[iLsGI`3I-TE1]+-SDYX]iV/#k_ppnzaB$T|!fOT_/%d,pmJ%D,$z[|Itg_Vs');
define('LOGGED_IN_KEY',    'uk4vo[W~&y))o&J^v4bUSsHl.Gh-ytIWfoK(R!->{GSU>Mnnm[@?:#Q83a)^!bsm');
define('NONCE_KEY',        '6FY4|z6y4naR.ULY8i5Jq$wZ|]P,K3=V#elD}O!<[WWTW%Zm Cm&e#`_R:7lV`4I');
define('AUTH_SALT',        'N{,%fI*BpL$XF75bns2%cEQWO_v;_`#p_=Nw@3iqT!WuU=T82}t82r{/~XDIdl6$');
define('SECURE_AUTH_SALT', 'ErLQf{t`P4]Lx3@>P~#!< /i[(5{6|SW![&d-W:i|<No5CN-*6&/5ptoZf9y0fwS');
define('LOGGED_IN_SALT',   'H1;[h{uV6aidWG:LvdHIdcux (7!,a$+*9kx&D3`PuBQ`Ddt/gJxay-J75*&~|#g');
define('NONCE_SALT',       'ZA/ED]j&U)Mu@ddfXRd0<k@pW9|bp9DnOk]i>qn*/mMQYE`Fy6;es}IM%+&R?AZA');

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
