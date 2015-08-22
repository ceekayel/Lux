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
$hostingsite = "trick-e";
$websites = array("lux","shop","directory");
$suffex_list = array("com", "net", "org");
/**
 * WordPress Database Table prefix.
 */
$table_prefix  = 'wp_lux_';

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
 */
$my_host = $_SERVER['HTTP_HOST'];
$my_origin = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_SCHEME) . '://' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST); //this has http or https portion

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
define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/../wp-content' );
define( 'WP_CONTENT_URL', $my_origin . '/wp-content' );

/* generally more is better than default of 40M */
define( 'WP_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

