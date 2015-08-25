<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
/**
 * The basic unique website domain
 */

//Use this when relocating the site, see https://codex.wordpress.org/Changing_The_Site_URL
//define('RELOCATE',true);

$hostingsite = "trick-e";
$websites = array("luxblox","shop","directory","home", "lux");
$suffex_list = array(".com", ".net", ".org", ".co");

/*
 * As suggested by http://luxblox.dev/wp-admin/network/setup.php
 * (should this go into settings.dev.php? does it change with the base URL?)
 */
define( 'AUTH_KEY', 'aRu^fP+N@tA.b,%MgsHiBK(F2B|cSJ3V!:6(F)tdk,h[P7[EK+`g%bPqXxYXz]P+' );
define( 'SECURE_AUTH_KEY', 'w*|r?-uSJ||hN!9<o*AI;;r=4/TTX7:@t>FPQit83=!v1By*0!|vYDsKC[(e!xB<' );
define( 'LOGGED_IN_KEY', 'UM$d{!o(0YnYa5.+ijxV{UrDZG<ZS|sLxp<;R1<|p+yNmOM~8.-aq5zO|~d6R|N/' );
define( 'NONCE_KEY', 'DX6*kD~GZ$;m`]sy%O_yFY5}^.`D@sL8$^OR<7v[2n4IV&|w!dE8^jH^&8sL6]EV' );
define( 'AUTH_SALT', '>Fg4}Q_kxag+wjbC16};OBvZ{?h#&--viZpu&<E/`1Lip?wP4|2.QN0$Zp]@^G_j' );
define( 'SECURE_AUTH_SALT', '+xLd[+3] u0KX,r4>V%eHMu<}V]wOP&X9zl|v*}1Tbl-++Kyx+6DHWF?uH0omkL*' );
define( 'LOGGED_IN_SALT', 'CRj-OpfhMN}:!]=wVE/i^jIzDZ2zTmAu?e$@U+=]%oc#[NsV@i=|.L|%Lj(+<|S5' );
define( 'NONCE_SALT', 'K#V[?j}rGaNsUgKWV^A%l2{e7o2>T+t,U0`-]Mprsf$U#Aj+0{Hn/_L2<rygR]<H' );

/**
 * Include settings.[environment].php
 *
 * Get the http host and then start removing pieces to eventually end up with
 * an environment identifier. The default environment is 'production'.
 *
 * Examples:
 *   yoursite.com = production
 *   www.yoursite.com = production
 *   yoursite.hostingsite.com = production
 *   stage.yoursite.hostingsite.com = stage
 *   stage.yoursite.com = stage
 *   local.yoursite.com = local
 *   local.yoursite = local
 *   yoursite.local = local
 *   yoursite.dev = dev
 */
$my_host = $_SERVER['HTTP_HOST'];
$my_scheme = $_SERVER['HTTP_REFERER'] ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_SCHEME) : "http";
$my_origin = $my_scheme . '://' . $my_host; //this has http or https portion

$domain_env = $my_host;
//strip suffixes
foreach ($suffex_list as $suffex) {
    $domain_env = str_replace($suffex, '', $my_host);
}

//strip known site names
$domain_env = str_replace($hostingsite, '', $domain_env);
foreach ($websites as $website) {
    $domain_env = str_replace($website, '', $domain_env);
}
//strip prefixes
$domain_env = str_replace('www.', '', $domain_env);

//strip any separators on ends (.)
$domain_env = trim($domain_env, '.');

//whatever is left is the environment
$domain_env = (strlen($domain_env) >= 1) ? $domain_env : 'production';

// Prefix configuration variables with 'my_config_' to avoid any clashes.
$conf['my_config_environment'] = ucfirst($domain_env);
$conf['my_config_settings_file'] = 'settings.' . $domain_env . '.php';

// Check if the file exists prior to including it.
if (file_exists(dirname(__FILE__) . '/../conf/' . $conf['my_config_settings_file'])) {
    require_once( dirname(__FILE__) . '/../conf/' .  $conf['my_config_settings_file']);
}

/* If multisite, add these */
define('WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', $my_host);
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* nice to have wp separated from other content */
// clip the subfolder rather than using /.. to go up (caused problems in plugins)
define( 'WP_CONTENT_DIR', str_replace('wp', '', dirname(__FILE__)) . '/wp-content' );
define( 'WP_CONTENT_URL', $my_origin . '/wp-content' );

//these help solve the too many redirects problem, usually in general settings
//define('WP_HOME','http://luxblox.dev');
//define('WP_SITEURL','http://luxblox.dev');

/* generally more is better than default of 40M */
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Absolute path to the base installation directory, given this installation is in wp subfolder. */
if ( !defined('ROOTPATH') )
    define('ROOTPATH', ABSPATH . '/..');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

