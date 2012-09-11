=== Plugin Name ===
Contributors: CodingFabian
Donate link: http://www.codecentric.de/
Tags: WPML, comments, multilingual, translation, i18n
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 1.3

This plugin merges comments from all WPML translations of the posts and pages, so that they all are displayed on each other.

== Description ==

Because WPML creates posts and pages for each language, comments from one do not appear on the other.
This plugin merges comments from all WPML translations of the posts and pages, so that they all are displayed on each other.
Comments are internally still attached to the post or page they were made on.

It uses the `get_comments()` api call, which in some circumstances might not return all posts.

== Installation ==

This plugin doesn't require any special installation.

1. Upload `wpml-comment-merging.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What types of content are supported =

Initially only posts were supported, but since 1.2 also pages are supported.

= Does it work with the WPML auto translation? =

It should, but I have not tested it. It hooks in after the WPML hooks (using prio 100) and uses the comments passed to it.

== Changelog ==

= 1.3 =
* Fix for regression in PHP breaking call_user_func calls ( Warning: Parameter 1 to get_post() expected to be a reference, value given in line 45 of wpml-comment-merging.php )

= 1.2 =
* Added support for merging comments on pages.

= 1.1 =
* Fixed issue with comment counting on start page when a post is not translated

= 1.0 =
* Initial Release