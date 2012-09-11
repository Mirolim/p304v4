<?php
if ( !defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}
	global $wpdb;
	delete_option('ald_wherego_settings');

	// Delete meta
	$sql = "DELETE FROM ".$wpdb->postmeta." WHERE `meta_key` = 'wheredidtheycomefrom'";
	$wpdb->query($sql);

?>