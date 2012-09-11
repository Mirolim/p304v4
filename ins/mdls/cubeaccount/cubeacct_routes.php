<?php
/**
 * CubeAccount Routing
 * Route requests to our custom pages
 * 
 * @package cubeaccount
 */

function cubeacct_wplogin_mapping($query){
	$action = $query['action'];
	unset($query['action']);
	switch($action){
		case 'logout':
			return cubeacct_url('logout', $query);
			break;
		case 'register':
			return cubeacct_url('register', $query);
			break;
		case 'lostpassword':
			return cubeacct_url('lostpassword', $query);
			break;
		case 'rp':
			return cubeacct_url('lostpassword', array_merge(array('action'=>'rp'), $query));
			break;
		default:
			if($query['checkemail']=='confirm'){
				return cubeacct_url('login', $query);
				break;
			}
			if($query['checkemail']=='registered'){
				return cubeacct_url('login', $query);
				break;
			}
			if(is_user_logged_in()&&!empty($_REQUEST['redirect_to'])){
				return $_REQUEST['redirect_to'];
				break;
			}
			return cubeacct_url('login', $query);
			break;
	}
}

function cubeacct_routing(){
	if(strstr($_SERVER['REQUEST_URI'],'wp-login.php')!==FALSE){
		wp_safe_redirect(cubeacct_wplogin_mapping($_GET));
		exit();
	}
}
add_action('init','cubeacct_routing');

?>