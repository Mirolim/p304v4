<?php
/**
 * CubeAccount - Hide WordPress dashboard
 * Function to hide the WordPress dashboard from certain users.
 * 
 * @package cubeaccount
 */

/**
 * Hides the WordPress dashboard depending on settings
 *
 * @return null
 */
function cubeacct_hide_dashboard(){
	$hide_dashboard_from = get_option('cubeacct_hide_dashboard_from', array());
	foreach($hide_dashboard_from as $capability){
		if(current_user_can($capability)){
			if(is_admin()&&!current_user_can('edit_posts')&&is_user_logged_in()&&!defined('DOING_AJAX')){
				wp_safe_redirect(cubeacct_url('profile'));
				exit();
			}
		}
	}
}

/** Hook to hide the WordPress dashboard */
add_action('init', 'cubeacct_hide_dashboard');

?>