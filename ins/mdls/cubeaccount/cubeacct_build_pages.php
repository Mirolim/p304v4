<?php
/**
 * CubeAccount Custom Pages
 * Builds custom pages on the fly
 * 
 * @package cubeaccount
 */

/**
 * Defines pages to be generated on the fly
 *
 * @return array
 */
function cubeacct_pages($id = null, $getSlugOnly = false){
	$cubeacct_pages['login'] = array('login', 'cubeacct_page_login');
	$cubeacct_pages['logout'] = array('logout', 'cubeacct_page_logout');
	$cubeacct_pages['lostpassword'] = array('lost-password', 'cubeacct_page_lostpassword');
	$cubeacct_pages['register'] = array('register', 'cubeacct_page_register');
	if($id == null){
		return $cubeacct_pages;
	}
	else if($getSlugOnly){
		return $cubeacct_pages[$id][0];
	}
	else{
		return $cubeacct_pages[$id];
	}
}
 
/**
 * Gets page data of custom page
 *
 * @param array $query the query string
 * @return array|bool page data of custom page or false if not found
 */
function cubeacct_get_page_data($query){
	$data = false;
	foreach(cubeacct_pages() as $page){
		if($query==$page[0]){
			$data = call_user_func($page[1]);
			break;
		}
	}
	return $data;
}

/**
 * Builds custom pages on the fly
 *
 * @return null
 */
function cubeacct_build_pages() {
	if(get_query_var(CUBEACCT_QUERY_VAR)!=''){
		if(get_query_var(CUBEACCT_QUERY_VAR)==cubeacct_pages('login', 1) && is_user_logged_in()){
			if(!empty($_REQUEST['redirect_to'])){
				wp_safe_redirect($_REQUEST['redirect_to']);
			}
			else{
				wp_safe_redirect(get_bloginfo('url'));
			}
		}
		$data = cubeacct_get_page_data(get_query_var(CUBEACCT_QUERY_VAR));
		if(!$data){
			return;
		}
		global $wp_query;
		$post = new stdClass();
		$post->ID=-100;
		$post->post_content=$data['content'];
		$post->post_title=$data['title'];
		$post->post_type='page';
		$wp_query->posts = array($post);
		$wp_query->post_count = 1;
		$wp_query->is_404 = false;
		remove_filter ('the_content',  'wpautop');
	}
}

/** Adds the hook to build custom pages on the fly **/
add_action('wp', 'cubeacct_build_pages');

/**
 * Filter to add query vars
 *
 * @return array
 */
function cubeacct_add_query_vars($query_vars) {
	$query_vars[] = CUBEACCT_QUERY_VAR;
	return $query_vars;
}

/** Adds the filter to include query vars **/
add_filter('query_vars', 'cubeacct_add_query_vars');

?>