<?php
/**
 * CubeAccount Installation.
 * Handles the installation of CubeAccount.
 * 
 * @package cubeaccount
 */

/**
 * Installs CubeAccount
 *
 * @return null
 */
function cubeacct_install() {

	// set default values
	add_option('cubeacct_check_passed', false);
	add_option('cubeacct_hide_adminbar_from', array('subscriber'));
	add_option('cubeacct_hide_dashboard_from', array('subscriber'));

}

/** Hook for plugin installation */
register_activation_hook( CUBEACCT_FILE , 'cubeacct_install' );

?>