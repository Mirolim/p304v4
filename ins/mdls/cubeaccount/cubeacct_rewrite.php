<?php
/**
 * CubeAccount Rewrite.
 * Handles the rewriting of URLs and the handling of custom pages.
 * 
 * @package cubeaccount
 */

/**
 * Generates page URL depending on rewrite
 *
 * @return string
 */
function cubeacct_url($slug, $additional_query = array()){
	$page = cubeacct_pages($slug);
	if ( get_option('permalink_structure') != '' ){
		return site_url('/' . $page[0] . '/') . ((count($additional_query)>0)?'?'.build_query($additional_query):'');
	}
	else{
		return site_url('/') . '?' . build_query(array_merge( array( CUBEACCT_QUERY_VAR => $page[0] ), $additional_query));
	}
}
 
/**
 * Flush rewrite rules if our rules are not yet included
 * 
 * @return null
 */
function cubeacct_flush_rules(){
	$rules = get_option( 'rewrite_rules' );
	$flush_rules = false;
	foreach(cubeacct_pages() as $page){
		if( ! isset( $rules['('.$page[0].')$'] ) ){
			$flush_rules = true;
			break;
		}
	}
	if ( $flush_rules ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
}

/**
 * Add new rewrite rule
 * 
 * @return array
 */
function cubeacct_insert_rewrite_rules( $rules ){
	$newrules = array();
	foreach(cubeacct_pages() as $page){
		$newrules['('.$page[0].')$'] = 'index.php?'. CUBEACCT_QUERY_VAR . '=' . $page[0];
	}
	return $newrules + $rules;
}

add_filter( 'rewrite_rules_array','cubeacct_insert_rewrite_rules' );
add_action( 'wp_loaded','cubeacct_flush_rules' );

/**
 * Fixes the wp_logout_url as the query vars is not added to site_url
 *
 * @return string
 */
function cubeacct_wp_logout_url($logout_url, $redirect){
	$query = array('action'=>'logout', '_wpnonce'=>wp_create_nonce('log-out'));
	if(!empty($redirect)){
		$query['redirect_to'] = $redirect;
	}
	return cubeacct_wplogin_mapping($query);
}
add_filter('logout_url', 'cubeacct_wp_logout_url', 10, 2);

/**
 * Rewrites all URLs with wp-login.php in the path
 *
 * @return string
 */
function cubeacct_site_url($url, $path, $orig_scheme, $blog_id){
	$path = parse_url($path);
	if(strstr($path['path'],'wp-login.php')===false) return $url;
	parse_str($path['query'],$query);
	$url = cubeacct_wplogin_mapping($query);
	return $url;
}
add_filter( 'site_url','cubeacct_site_url', 10, 4 );
?>