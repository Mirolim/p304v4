<?php
/**
 * CubeAccount - Disable Admin Bar
 * Function to disable the WordPress admin bar.
 * 
 * @package cubeaccount
 */

/**
 * Disables the WordPress admin bar depending on settings
 *
 * @return null
 */
function cubeacct_hide_adminbar(){
	$hide_adminbar_from = get_option('cubeacct_hide_adminbar_from', array());
	foreach($hide_adminbar_from as $capability){
		if(current_user_can($capability)){
			show_admin_bar(false);
		}
	}
}

/** Hook to disable the WordPress admin bar */
add_action('init', 'cubeacct_hide_adminbar');

?>