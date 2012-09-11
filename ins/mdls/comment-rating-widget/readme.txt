=== Comment Rating Widget ===
Contributors: bobking
Tags: widget, sidebar, comments, vote, poll, polls, image, images, performance, rating, ratings, comment, AJAX, javascript, automatic, button, plugin, plugins, Dislike, Like, embed, Formatting, user, users, visitors, text, counter, cms, highlight, digg, integration, thumb, tool, tools, style, youtube, community, star, any, google, buttons, seo, save, saving, highlight, highlighter, addtoany
Donate link: http://WealthyNetizen.com/donate/
Requires at least: 2.3
Tested up to: 3.3.2
Stable tag: 2.0.6.7

Add on to the Comment Rating plugin. Display ratings along with the most recent comments in the sidebar. Built upon Get Recent Comment widget. 

== Description ==

This plugin is an add on to the Comment Rating plugin (version 2.9.0 or later). It displays ratings
along with the most recent comments in the sidebar in formats of your design.
The comment rating and images on display can be "Likes only", "Dislikes only", or Both. 
This is customizable by the "Value for comment_karma" option in Comment Rating.
An example website is <a href="http://WealthyNetizen.com">Wealthy Netizen</a>.

To avoid reinventing the wheel, the plugin is built upon Krischan
Jodies' popular and stable "Get Recent Comment" widget.  All the
features of "Get Recent Comment" remain as is. The "Comment Rating
Widge" plugin will track the most recent release "Get Recent Comment".

If the Comment Rating plugin is not present, this plug in
will function exactly as "Get Recent Comment".

The following is Krischan Jodies' description of <a href="http://blog.jodies.de/2004/11/recent-comments/">Get Recent Comment</a>.

This plugin shows excerpts of the latest comments and/or trackbacks in your
sidebar. You have comprehensive control about their appearance. This ranges
from the number of comments, the length of the excerpts up to the html layout.
You can let the plugin order the comments by the corresponding post, or simply
order them by date. The plugin can (optionally) separate the
trackbacks/pingbacks from the comments. It can ignore comments to certain
categories, and it offers support for gravatars. It only gives extra work to
the database, when actually a new comment arrived. You can filter out
unwanted pingbacks, which originate from your own blog. And it is a widget.

*Feature List*

* Highly configurable via WordPress admin interface.
* Adjustable layout by macros.
* Handles trackbacks and comments in separate lists, or in one combined list.
* Widget support
* Caches the output
* Order comments by date, or by posting
* Support for Gravatars
* Option to exclude comments to posts in certain categories
* Doesn’t show pingbacks originating from own blog

== Installation ==

1. After download the plug in, you can upload and install it from 
Wordpress Dashboard -> Plugins -> Add New. Alternatively, you can
unpack and upload the dir with files to the wp-content/plugins folder on your blog.  

1. Activate the plugin.

1. You also need to install Comment Rating plugin version 2.9.0 or
later.  If the Comment Rating plugin is not present, this plug in
will function exactly as "Get Recent Comment".

1. Now you need to add the widget to your sidebar.  Go to Appearance
-> Widgets and drag the "Comment Rating Widget" the desired sidebar. 

1. You can configure the options under Setting -> Comment Rating
Widget.  The default options should be good enough.
 
1. The comment rating and images on display can be "Likes only",
"Dislikes only", or Both.  This is customizable by the "Value for
comment_karma" option in Comment Rating (under Advanced Option).
 
If you have any question, please see <a href="http://wealthynetizen.com/comment-rating-widget-faq/"> Comment Rating Widget plugin FAQ</a>.

== Frequently Asked Questions ==

For complete and most up-to-date FAQ, please see <a href="http://wealthynetizen.com/comment-rating-widget-faq/"> Comment Rating Widget plugin FAQ</a>.

* Do I need both Get Recent Comment and Comment Rating Widget plugins?

No you don't.  You only need to have Comment Rating Widget activated.  If you keep both plugin activated, there will be a conflict.

In fact, if you had Get Recent Comment installed before, you need to click the "Reset template to default" to get the Comment Rating Widget template.

* How do I control the displayed image and rating in the widget?

The comment rating and images on display can be 'Likes only', 'Dislikes only', or Both.  This is customizable by the 'Value for comment_karma' option in Comment Rating (under Advanced Option).

* I made the change to the Comment Rating 'Value for comment_karma', but there's no change on the sidebar.

The plugin comes with an internal cache to reduce performance
impact on page loading.  You have to clean the cache by clicking on
Comment Rating Widget option 'Update recent comment options'
at the bottom.

* If the Comment Rating plugin is not installed, will this widget still work?

Yes, this plug in will function exactly as 'Get Recent Comment'.

== Screenshots ==

1. Example a Wordpress installation right after installation.

2. Option page showing the rich & flexible configuration features.

3. How widget is added to the sidebar.

== Changelog ==

= 2.0.6.7 =

It took me a while to upgrade from PHP 5.1.6 to PHP 5.3.2 and
install WordPress 3.2.1.  Now Comment Rating Widget is tested on WP 3.2.1,
again still works like a charm.


= 2.0.6.6 =

There was a problem in Wordpress 3.0.1. Comments are not showing up
in widget.  However before I can figure out what was wrong, it
fixed itself in Wordpress 3.0.2.

= 2.0.6.5 =

Tested in Wordpress 3.0

= 2.0.6.4 =

Fix bug: URL to the pagenated comment is broken.
This is a bug inherited from Get Recent Comment plugin

Note that this only fixes the problem when you use Wordpress's
built-in paged comment.  If you page your comments with plug-ins,
e.g. "WP Paged Comments" and "Paged comments", it still won't work.

= 2.0.6.3 =

Tested for Wordpress 2.9/2.9.1.

= 2.0.6.2 =

Add screenshots.

= 2.0.6.1 =

Tested for Wordpress 2.8.6

= 2.0.6.0 =

Created from "Get Recent Comment" version 2.0.6.  Fully tested with
Comment Rating version 2.9.0.

