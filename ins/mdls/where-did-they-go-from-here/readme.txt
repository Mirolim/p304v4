=== Where did they go from here ===
Tags: related posts, visitors, browsing, visitors, tracking
Contributors: Ajay, Mark Ghosh
Donate link: http://ajaydsouza.com/donate/
Stable tag: trunk
Requires at least: 2.5
Tested up to: 3.4


Show "Readers who viewed this page, also viewed" links on your page. Much like Amazon.com's product pages.

== Description ==

Have you seen Amazon.com's product pages? They all have a "Readers who have bought this, also bought. So, why not implement this on your WordPress blog?

This plugin will show "Readers who viewed this page, also viewed" links on your page.

= Features =
* Display Related Posts automatically in content / feed, no need to edit template files
* Tracks visitors movement along your site
* You can manually add related posts where you want them displayed
* Exclude pages from the list of posts
* Display post thumbnails in the list. The plugin has support for WordPress 2.9 thumbnails, use of postmeta and also the ability to grab the first image in the post


== Installation ==

1. Download the plugin
2. Extract the contents of where-did-they-go-from-here.zip to wp-content/plugins/ folder. You should get a folder called where-did-they-go-from-here.
3. Activate the Plugin in WP-Admin. 
4. Goto Settings > Where go to configure


== Upgrade Notice ==

= 1.5.4 =
* Fixed: Error when deleting the plugin

== Changelog ==

= 1.5.4 =
* Fixed: Error when deleting the plugin

= 1.5.3 =
* Added: Better support for custom post types

= 1.5.2 =
* Fixed: PHP Notices for "Use of undefined constant limit"

= 1.5.1 =
* Added: Russian translation

= 1.5 =
* Fixed: Compability problem with WordPress blog in the subdirectory
* Added: Option to excludes posts from certain categories to be displayed

= 1.4.2 =
* Fixed: Languages were not detected properly. Added Italian language

= 1.4.1 =
* Fixed: Minor compatibility issue with other plugins

= 1.4 =
* New: Implementation for tracking hits even on blogs with non-standard WordPress installs
* New: Reset button to reset all browsing data
* New: Option to exclude pages in post list
* New: Choose if you want to blank out display or display a custom message
* New: The plugin extracts the first image in the post and displays that if the post thumbnail and the post-image meta field is missing
* Fixed: Postmeta detection for thumbnails
* Fixed: Compatibility with caching plugins like W3 Total Cache and WP Super Cache
* Some optimisation and code cleaning for better performance

= 1.3.1 =
* Fixed problem where plugin was not tracking visits properly

= 1.3 =
* Added localisation support
* Better support for blogs where wp-content folder has been moved
* Added support for post thumbnails
* Added option to display the post excerpt in the list
* All parts of the list are now wrapped in classes for easy CSS customisation
* Uninstall will clean up the meta tables

= 1.2.1 =
* Fixed compatibility issues with WordPress 2.9

= 1.2 =
* Fixed a bug with posts not being tracked on blogs hosted in a folder

= 1.1 =
* Compatible with caching plugins. Tweaks that should improve tracking.
* Display the list of posts in Edit pages / posts of WP-Admin
* Blanked out display when no related posts are found instead of #N/A

= 1.0 =
* Release


== Frequently Asked Questions ==

= What are the requirements for this plugin? =

WordPress 2.5 or above


= Can I customize what is displayed? =

All options can be customized within the Options page in WP-Admin itself

You can customise the CSS output. This plugin uses the following CSS classes:
* `wherego_related` in the `div` that surrounds the list items
* `wherego_thumb` is the class that is used for the thumbnail / post image
* `wherego_title` is the class that is used for the title / text
* `wherego_excerpt` is the class that is used for the excerpt

You can add code to your *style.css* file of your theme to style the related posts list.

For more information, please visit http://ajaydsouza.com/wordpress/plugins/where-did-they-go-from-here/

= Support =

I offer limited support on the plugins. Details on how to receive support are at http://ajaydsouza.com/support/
