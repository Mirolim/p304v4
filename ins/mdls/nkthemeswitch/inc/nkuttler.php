<?php

/**
 * Information about the author 0.2.2
 */

if ( !function_exists( 'nkuttler022_links' ) ) {
	function nkuttler0_2_2_links( $plugin ) {
	
		$name			= 'Nicolas Kuttler';
		$gravatar		= '7b75fc655756dd5c58f4df1f4083d2e2.jpg';
		$url_author		= 'http://www.nkuttler.de';
		$url_plugin		= $url_author . '/wordpress/' . $plugin;
		$feedburner		= 'http://feedburner.google.com/fb/a/mailverify?uri=NicolasKuttler&loc=en_US'; // subscribe feed per mail
		$profile		= 'http://wordpress.org/extend/plugins/profile/nkuttler';
	
		/***/
	
		$vote			= 'http://wordpress.org/extend/plugins/' . $plugin;
		$homeFeed		= 'http://www.nkuttler.de/feed/';
		$donate			= 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=11041772';
		$commentsFeed	= $url_plugin . '/feed/'; ?>
	
		 <?php
	}
}

?>
