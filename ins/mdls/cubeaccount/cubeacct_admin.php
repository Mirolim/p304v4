<?php
/**
 * CubeAccount Admin Functions.
 * Handles admin pages.
 * @package cubeaccount
 */

/**
 * Hook for setting up admin pages
 * 
 * @return null
 */
function cubeacct_admin() {
	add_menu_page('CubeAccount', 'CubeAccount', 'manage_options', 'cubeacct_admin_config', 'cubeacct_admin_config');
	add_submenu_page('cubeacct_admin_config', 'CubeAccount - ' . __('Configure', 'cubeacct') , __('Configure', 'cubeacct'), 'manage_options', 'cubeacct_admin_config', 'cubeacct_admin_config');
}

/** Include admin pages */
require_once('cubeacct_admin_config.php');

/** Hook for admin pages */
add_action('admin_menu', 'cubeacct_admin');

?>