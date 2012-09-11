<?php 
// ACF address add-on
include_once( rtrim( dirname( __FILE__ ), '/' ) . '/acf-address-field/address-field.php' );

// Register Location custom field
if (function_exists('register_field')) {
    register_field('Location_field', dirname(__FILE__) . '/custom-fields/location.php');
}
// register ACF taxonomy check box field
if( function_exists( 'register_field' ) )
{
    register_field('Tax_field', dirname(__File__) . '/custom-fields/acf-tax.php');
}
// Preventing viewing others post
function posts_for_current_author($query) {
	global $user_level;

	if($query->is_admin && $user_level < 5) {
		global $user_ID;
		$query->set('author',  $user_ID);
		unset($user_ID);
	}
	unset($user_level);

	return $query;
}
add_filter('pre_get_posts', 'posts_for_current_author');

add_filter('query_vars', 'parameter_queryvars' );

function parameter_queryvars( $qvars )
{
$qvars[] = 'loc';
$qvars[] = 'radius';
return $qvars;
}
/**
 * Add to use custom post templates for custom post types
 * Hooks the WP cpt_post_types filter 
 *
 * @param array $post_types An array of post type names that the templates be used by
 * @return array The array of post type names that the templates be used by
 **/
function my_cpt_post_types( $post_types ) {
	$post_types[] = 'restaurants';
	return $post_types;
}
add_filter( 'cpt_post_types', 'my_cpt_post_types' );
// remove junk from head
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove CSS added from the Recent Comments widget
function roots_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

add_action('wp_head', 'roots_remove_recent_comments_style', 1);

// Remove CSS added from galleries
function roots_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

add_filter('gallery_style', 'roots_gallery_style');

/**
 * Replace various active menu class names with "active"
 */
function roots_wp_nav_menu($text) {
  $replace = array(
    'current-menu-item'     => 'active',
    'current-menu-parent'   => 'active',
    'current-menu-ancestor' => 'active',
    'current_page_item'     => 'active',
    'current_page_parent'   => 'active',
    'current_page_ancestor' => 'active',
  );

  $text = str_replace(array_keys($replace), $replace, $text);
  return $text;
}

add_filter('wp_nav_menu', 'roots_wp_nav_menu');

/**
 * Cleaner walker for wp_nav_menu()
 *
 * Walker_Nav_Menu (WordPress default) example output:
 *   <li id="menu-item-8" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8"><a href="/">Home</a></li>
 *   <li id="menu-item-9" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-9"><a href="/sample-page/">Sample Page</a></li>
 *
 * Roots_Nav_Walker example output:
 *   <li class="menu-home"><a href="/">Home</a></li>
 *   <li class="menu-sample-page"><a href="/sample-page/">Sample Page</a></li>
 */
class Roots_Nav_Walker extends Walker_Nav_Menu {
  function check_current($classes) {
    return preg_match('/(current[-_])/', $classes);
  }

  function start_el(&$output, $item, $depth, $args) {
    global $wp_query;
    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $slug = sanitize_title($item->title);
    $id = apply_filters('nav_menu_item_id', 'menu-' . $slug, $item, $args);
    $id = strlen($id) ? '' . esc_attr( $id ) . '' : '';

    $class_names = $value = '';
    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes = array_filter($classes, array(&$this, 'check_current'));

    if ($custom_classes = get_post_meta($item->ID, '_menu_item_classes', true)) {
      foreach ($custom_classes as $custom_class) {
        $classes[] = $custom_class;
      }
    }

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = $class_names ? ' class="' . $id . ' ' . esc_attr($class_names) . '"' : ' class="' . $id . '"';

    $output .= $indent . '<li' . $class_names . '>';

    $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
    $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
    $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
    $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';

    $item_output  = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
// Rewrite /wp-content/themes/theme-name/css/ to /css/
// Rewrite /wp-content/themes/theme-name/js/  to /js/
// Rewrite /wp-content/themes/theme-name/img/ to /img/
// Rewrite /wp-content/plugins/ to /plugins/

function roots_flush_rewrites() {
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

function roots_add_rewrites($content) {
  $theme_name = next(explode('/themes/', get_stylesheet_directory()));
  global $wp_rewrite;
  $roots_new_non_wp_rules = array(
    'css/(.*)'      => 'wp-content/themes/'. $theme_name . '/css/$1',
    'js/(.*)'       => 'wp-content/themes/'. $theme_name . '/js/$1',
    'img/(.*)'      => 'wp-content/themes/'. $theme_name . '/img/$1',
    'plugins/(.*)'  => 'wp-content/plugins/$1'
  );
  $wp_rewrite->non_wp_rules += $roots_new_non_wp_rules;
}

add_action('admin_init', 'roots_flush_rewrites');

function roots_clean_assets($content) {
  $theme_name = next(explode('/themes/', $content));
  $current_path = '/wp-content/themes/' . $theme_name;
  $new_path = '';
  $content = str_replace($current_path, $new_path, $content);
  return $content;
}

function roots_clean_plugins($content) {
  $current_path = '/wp-content/plugins';
  $new_path = '/plugins';
  $content = str_replace($current_path, $new_path, $content);
  return $content;
}

add_action('generate_rewrite_rules', 'roots_add_rewrites');
if (!is_admin()) {
  add_filter('plugins_url', 'roots_clean_plugins');
  add_filter('bloginfo', 'roots_clean_assets');
  add_filter('stylesheet_directory_uri', 'roots_clean_assets');
  add_filter('template_directory_uri', 'roots_clean_assets');
  add_filter('script_loader_src', 'roots_clean_plugins');
  add_filter('style_loader_src', 'roots_clean_plugins');

}
/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function roots_root_relative_url($input) {
  $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
      '$matches',
      // If full URL is home_url("/"), return a slash for relative root
      'if (isset($matches[0]) && $matches[0] === home_url("/")) { return "/";' .
      // If domain is equal to home_url("/"), then make URL relative
      '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
      // If domain is not equal to home_url("/"), do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );

  return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function roots_fix_duplicate_subfolder_urls($input) {
  $output = roots_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }

  return $output;
}

if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
  add_filter('bloginfo_url', 'roots_root_relative_url');
  add_filter('theme_root_uri', 'roots_root_relative_url');
  add_filter('stylesheet_directory_uri', 'roots_root_relative_url');
  add_filter('template_directory_uri', 'roots_root_relative_url');
  add_filter('script_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'roots_root_relative_url');
  add_filter('the_permalink', 'roots_root_relative_url');
  add_filter('wp_list_pages', 'roots_root_relative_url');
  add_filter('wp_list_categories', 'roots_root_relative_url');
  add_filter('wp_nav_menu', 'roots_root_relative_url');
  add_filter('the_content_more_link', 'roots_root_relative_url');
  add_filter('the_tags', 'roots_root_relative_url');
  add_filter('get_pagenum_link', 'roots_root_relative_url');
  add_filter('get_comment_link', 'roots_root_relative_url');
  add_filter('month_link', 'roots_root_relative_url');
  add_filter('day_link', 'roots_root_relative_url');
  add_filter('year_link', 'roots_root_relative_url');
  add_filter('tag_link', 'roots_root_relative_url');
  add_filter('the_author_posts_link', 'roots_root_relative_url');
}
/*
The wp-includes directory holds jquery and various other js files that themes or plugins will call using wp_enqueue_script(). To change this you will need to deregister the default WordPress scripts and register the new location. Add to functions.php:
*/
function my_init() {
    if (!is_admin()) {
        // comment out the next two lines to load the local copy of jQuery
        wp_deregister_script('sack');
        wp_register_script('sack','/js/tw-sack.js?ver=1.6.1');
        wp_enqueue_script('sack');
		wp_deregister_script('admin-bar');
        wp_register_script('admin-bar', '/js/admin-bar.js?ver=3.4.1');
        wp_enqueue_script('admin-bar');
    }
}
add_action('init', 'my_init');

//WMPL configuration
define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);
remove_action( 'wp_head', array($sitepress, 'meta_generator_tag' ) );

?>