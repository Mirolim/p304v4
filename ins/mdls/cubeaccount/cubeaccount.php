<?php
/*
Plugin Name: CubeAccount Frontend Login
Description: CubeAccount Frontend Login lets your users login and register from the frontend of your site. The WordPress dashboard and admin bar can be hidden completely from your users. Works well with other plugins that adds features to the login and registration form.
Author: Jonathan Lau
Version: 1.0
Author URI: http://cubepoints.com/go/cubeaccount
*/

global $wpdb;

/** Define constants */
define('CUBEACCT_VER', '1.0');
define('CUBEACCT_PATH', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));
define('CUBEACCT_FILE', __FILE__);
define('CUBEACCT_QUERY_VAR', 'ca_action');

/** Loads the plugin's translated strings */
load_plugin_textdomain('cubeacct', false, dirname(plugin_basename(__FILE__)).'/languages/');

/** Includes install script */
require_once 'cubeacct_install.php'; 

/** Include admin pages **/
require_once('cubeacct_admin.php');

/** Include functions for disabling admin bar **/
require_once('cubeacct_adminbar.php');

/** Include functions for hiding the WordPress admin dashboard **/
require_once('cubeacct_dashboard.php');

/** Include common functions from wp-login.php **/
require_once('cubeacct_wplogin.php');
require_once('cubeacct_page_account.php');

/** Include functions for building pages on the fly **/
require_once('cubeacct_build_pages.php');

/** Include functions to rewrite page URLs **/
require_once('cubeacct_rewrite.php');

/** Include functions to route requests to our custom pages **/
require_once('cubeacct_routes.php');


/** Include stylesheets **/
function cubeacct_css() {
	wp_register_style('cubeacct', plugins_url('style.css', CUBEACCT_FILE));
	wp_enqueue_style('cubeacct');
}
add_action('wp_print_styles', 'cubeacct_css');


?>