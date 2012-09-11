<?php
/**********************************************************************
*					Admin Page										*
*********************************************************************/
function wherego_options() {
	
	global $wpdb;
    $poststable = $wpdb->posts;

	$wherego_settings = wherego_read_options();

	if($_POST['wherego_save']){
		$wherego_settings[title] = ($_POST['title']);
		$wherego_settings[limit] = intval($_POST['limit']);
		$wherego_settings[exclude_cat_slugs] = ($_POST['exclude_cat_slugs']);
		$wherego_settings[add_to_content] = (($_POST['add_to_content']) ? true : false);
		$wherego_settings[add_to_feed] = (($_POST['add_to_feed']) ? true : false);
		$wherego_settings[wg_in_admin] = (($_POST['wg_in_admin']) ? true : false);
		$wherego_settings[show_credit] = (($_POST['show_credit']) ? true : false);
		$wherego_settings[exclude_pages] = (($_POST['exclude_pages']) ? true : false);
		$wherego_settings[blank_output] = (($_POST['blank_output'] == 'blank' ) ? true : false);
		$wherego_settings[blank_output_text] = $_POST['blank_output_text'];
		
		$wherego_settings[post_thumb_op] = $_POST['post_thumb_op'];
		$wherego_settings[before_list] = $_POST['before_list'];
		$wherego_settings[after_list] = $_POST['after_list'];
		$wherego_settings[before_list_item] = $_POST['before_list_item'];
		$wherego_settings[after_list_item] = $_POST['after_list_item'];
		$wherego_settings[thumb_meta] = $_POST['thumb_meta'];
		$wherego_settings[thumb_default] = $_POST['thumb_default'];
		$wherego_settings[thumb_height] = intval($_POST['thumb_height']);
		$wherego_settings[thumb_width] = intval($_POST['thumb_width']);
		$wherego_settings[scan_images] = (($_POST['scan_images']) ? true : false);
		$wherego_settings[show_excerpt] = (($_POST['show_excerpt']) ? true : false);
		$wherego_settings[excerpt_length] = intval($_POST['excerpt_length']);

		$exclude_categories_slugs = explode(", ",$wherego_settings[exclude_cat_slugs]);
		
		$exclude_categories = '';
		foreach ($exclude_categories_slugs as $exclude_categories_slug) {
			$catObj = get_category_by_slug($exclude_categories_slug);
			$exclude_categories .= $catObj->term_id . ',';
		}
		$wherego_settings[exclude_categories] = substr($exclude_categories, 0, -2);

		update_option('ald_wherego_settings', $wherego_settings);
		
		$str = '<div id="message" class="updated fade"><p>'. __('Options saved successfully.',WHEREGO_LOCAL_NAME) .'</p></div>';
		echo $str;
	}
	
	if ($_POST['wherego_default']){
		delete_option('ald_wherego_settings');
		$wherego_settings = wherego_default_options();
		update_option('ald_wherego_settings', $wherego_settings);
		
		$str = '<div id="message" class="updated fade"><p>'. __('Options set to Default.',WHEREGO_LOCAL_NAME) .'</p></div>';
		echo $str;
	}

	if ($_POST['wherego_reset']){
		// Delete meta
		$str = '<div id="message" class="updated fade"><p>'. __('All visitor browsing data captured by the plugin has been deleted!',WHEREGO_LOCAL_NAME) .'</p></div>';
		$sql = "DELETE FROM ".$wpdb->postmeta." WHERE `meta_key` = 'wheredidtheycomefrom'";
		$wpdb->query($sql);
	
		echo $str;
	}
?>

<div class="wrap">
  <h2>Where did they go from here? </h2>
  <div id="options-div">
  <form method="post" id="wherego_options" name="wherego_options" style="border: #ccc 1px solid; padding: 10px">
    <fieldset class="options">
    <legend>
    <h3>
      <?php _e('Options:',WHEREGO_LOCAL_NAME); ?>
    </h3>
    </legend>
    <p>
      <label>
      <?php _e('Number of posts to display: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="limit" id="limit" value="<?php echo stripslashes($wherego_settings[limit]); ?>">
      </label>
    </p>
    <p><?php _e('Exclude Categories: ',WHEREGO_LOCAL_NAME); ?></p>
	<div style="position:relative;text-align:left">
		<table id="MYCUSTOMFLOATER" class="myCustomFloater" style="position:absolute;top:50px;left:0;background-color:#cecece;display:none;visibility:hidden">
		<tr><td><!--
				please see: http://chrisholland.blogspot.com/2004/09/geekstuff-css-display-inline-block.html
				to explain why i'm using a table here.
				You could replace the table/tr/td with a DIV, but you'd have to specify it's width and height
				-->
			<div class="myCustomFloaterContent">
			you should never be seeing this
			</div>
		</td></tr>
		</table>
		<textarea class="wickEnabled:MYCUSTOMFLOATER" cols="50" rows="3" wrap="virtual" name="exclude_cat_slugs"><?php echo (stripslashes($wherego_settings[exclude_cat_slugs])); ?></textarea>
	</div>
    <p>
      <label>
      <input type="checkbox" name="add_to_content" id="add_to_content" <?php if ($wherego_settings[add_to_content]) echo 'checked="checked"' ?> />
      <?php _e('Add list of posts to the post content on single posts. <br />If you choose to disable this, please add <code>&lt;?php if(function_exists(\'echo_ald_wherego\')) echo_ald_wherego(); ?&gt;</code> to your template file where you want it displayed',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="add_to_feed" id="add_to_feed" <?php if ($wherego_settings[add_to_feed]) echo 'checked="checked"' ?> />
      <?php _e('Add list of posts to feed',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="wg_in_admin" id="wg_in_admin" <?php if ($wherego_settings[wg_in_admin]) echo 'checked="checked"' ?> />
      <?php _e('Display list of posts in Edit Posts / Pages',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="show_credit" id="show_credit" <?php if ($wherego_settings[show_credit]) echo 'checked="checked"' ?> />
      <?php _e('Append link to this plugin as item. Optional, but would be nice to give me some link love',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <h4>
      <?php _e('Output Options:',WHEREGO_LOCAL_NAME); ?>
    </h4>
    <p>
      <label>
      <?php _e('Title of posts: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="title" id="title" value="<?php echo stripslashes($wherego_settings[title]); ?>">
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="exclude_pages" id="exclude_pages" <?php if ($wherego_settings[exclude_pages]) echo 'checked="checked"' ?> />
      <?php _e('Exclude pages from the post list',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="show_excerpt" id="show_excerpt" <?php if ($wherego_settings[show_excerpt]) echo 'checked="checked"' ?> />
      <strong><?php _e('Show post excerpt in list?',WHEREGO_LOCAL_NAME); ?></strong>
      </label>
    </p>
    <p>
      <label>
      <?php _e('Length of excerpt (in words): ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="excerpt_length" id="excerpt_length" value="<?php echo stripslashes($wherego_settings[excerpt_length]); ?>">
      </label>
    </p>
	<h4><?php _e('Customize the output:',WHEREGO_LOCAL_NAME); ?></h4>
	<p>
      <label>
      <?php _e('HTML to display before the list of posts: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="before_list" id="before_list" value="<?php echo attribute_escape(stripslashes($wherego_settings[before_list])); ?>">
      </label>
	</p>
	<p>
      <label>
      <?php _e('HTML to display before each list item: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="before_list_item" id="before_list_item" value="<?php echo attribute_escape(stripslashes($wherego_settings[before_list_item])); ?>">
      </label>
	</p>
	<p>
      <label>
      <?php _e('HTML to display after each list item: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="after_list_item" id="after_list_item" value="<?php echo attribute_escape(stripslashes($wherego_settings[after_list_item])); ?>">
      </label>
	</p>
	<p>
      <label>
      <?php _e('HTML to display after the list of posts: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="after_list" id="after_list" value="<?php echo attribute_escape(stripslashes($wherego_settings[after_list])); ?>">
      </label>
	</p>
	<p><strong><?php _e('When there are no posts, what should be shown?',WHEREGO_LOCAL_NAME); ?></strong><br />
		<label>
		<input type="radio" name="blank_output" value="blank" id="blank_output_0" <?php if ($wherego_settings['blank_output']) echo 'checked="checked"' ?> />
		<?php _e('Blank Output',WHEREGO_LOCAL_NAME); ?></label>
		<br />
		<label>
		<input type="radio" name="blank_output" value="noposts" id="blank_output_1" <?php if (!$wherego_settings['blank_output']) echo 'checked="checked"' ?> />
		<?php _e('Display custom text: ',WHEREGO_LOCAL_NAME); ?></label><br />
		<textarea name="blank_output_text" id="blank_output_text" cols="50" rows="5"><?php echo htmlspecialchars(stripslashes($wherego_settings[blank_output_text])); ?></textarea>
		<br />
	</p>
	<h4><?php _e('Post thumbnail options:',WHEREGO_LOCAL_NAME); ?></h4>
	<p>
		<label>
		<input type="radio" name="post_thumb_op" value="inline" id="post_thumb_op_0" <?php if ($wherego_settings['post_thumb_op']=='inline') echo 'checked="checked"' ?> />
		<?php _e('Display thumbnails inline with posts',WHEREGO_LOCAL_NAME); ?></label>
		<br />
		<label>
		<input type="radio" name="post_thumb_op" value="thumbs_only" id="post_thumb_op_1" <?php if ($wherego_settings['post_thumb_op']=='thumbs_only') echo 'checked="checked"' ?> />
		<?php _e('Display only thumbnails, no text',WHEREGO_LOCAL_NAME); ?></label>
		<br />
		<label>
		<input type="radio" name="post_thumb_op" value="text_only" id="post_thumb_op_2" <?php if ($wherego_settings['post_thumb_op']=='text_only') echo 'checked="checked"' ?> />
		<?php _e('Do not display thumbnails, only text.',WHEREGO_LOCAL_NAME); ?></label>
		<br />
	</p>
    <p>
      <label>
      <?php _e('Post thumbnail meta field (the meta should point contain the image source): ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="thumb_meta" id="thumb_meta" value="<?php echo attribute_escape(stripslashes($wherego_settings[thumb_meta])); ?>">
      </label>
    </p>
    <p>
      <label>
      <input type="checkbox" name="scan_images" id="scan_images" <?php if ($wherego_settings[scan_images]) echo 'checked="checked"' ?> />
      <?php _e('If the postmeta is not set, then should the plugin extract the first image from the post. This can slow down the loading of your post if the first image in the related posts is large in file-size',WHEREGO_LOCAL_NAME); ?>
      </label>
    </p>
    <p><strong><?php _e('Thumbnail dimensions:',WHEREGO_LOCAL_NAME); ?></strong><br />
      <label>
      <?php _e('Max width: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="thumb_width" id="thumb_width" value="<?php echo attribute_escape(stripslashes($wherego_settings[thumb_width])); ?>" style="width:30px">px
      </label>
	  <br />
      <label>
      <?php _e('Max height: ',WHEREGO_LOCAL_NAME); ?>
      <input type="textbox" name="thumb_height" id="thumb_height" value="<?php echo attribute_escape(stripslashes($wherego_settings[thumb_height])); ?>" style="width:30px">px
      </label>
    </p>
	<p><?php _e('The plugin will first check if the post contains a thumbnail. If it doesn\'t then it will check the meta field. If this is not available, then it will show the default image as specified below:',WHEREGO_LOCAL_NAME); ?>
	<input type="textbox" name="thumb_default" id="thumb_default" value="<?php echo attribute_escape(stripslashes($wherego_settings[thumb_default])); ?>" style="width:500px">
	</p>
    <p>
      <input type="submit" name="wherego_save" id="wherego_save" value="Save Options" style="border:#00CC00 1px solid" />
      <input name="wherego_default" type="submit" id="wherego_default" value="Default Options" style="border:#FF0000 1px solid" onclick="if (!confirm('<?php _e('Do you want to set options to Default?',WHEREGO_LOCAL_NAME); ?>')) return false;" />
    </p>
    <p><?php _e('Reset all content? This will purge WordPress of all visitor browsing information captured by this plugin. There is no going back if you hit the button.',WHEREGO_LOCAL_NAME); ?><br />
      <input name="wherego_reset" type="submit" id="wherego_reset" value="Reset browsing data" style="border:#FFFF00 1px solid" onclick="if (!confirm('<?php _e('This will delete all user data',WHEREGO_LOCAL_NAME); ?>')) return false;" />
    </p>
    </fieldset>
  </form>
  </div>

  <div id="side">
	<div class="side-widget">
	<span class="title"><?php _e('Quick links') ?></span>				
	<ul>
		<li><a href="http://ajaydsouza.com/wordpress/plugins/where-did-they-go-from-here/"><?php _e('Where did they go from here? ');_e('plugin page',WHEREGO_LOCAL_NAME) ?></a></li>
		<li><a href="http://ajaydsouza.com/wordpress/plugins/"><?php _e('Other plugins',WHEREGO_LOCAL_NAME) ?></a></li>
		<li><a href="http://ajaydsouza.com/"><?php _e('Ajay\'s blog',WHEREGO_LOCAL_NAME) ?></a></li>
		<li><a href="http://ajaydsouza.com/support/"><?php _e('Support',WHEREGO_LOCAL_NAME) ?></a></li>
		<li><a href="http://twitter.com/ajaydsouza"><?php _e('Follow @ajaydsouza on Twitter',WHEREGO_LOCAL_NAME) ?></a></li>
	</ul>
	</div>
	<div class="side-widget">
	<span class="title"><?php _e('Recent developments',WHEREGO_LOCAL_NAME) ?></span>				
	<?php require_once(ABSPATH . WPINC . '/rss.php'); wp_widget_rss_output('http://ajaydsouza.com/archives/category/wordpress/plugins/feed/', array('items' => 5, 'show_author' => 0, 'show_date' => 1));
	?>
	</div>
	<div class="side-widget">
		<span class="title"><?php _e('Support the development',WHEREGO_LOCAL_NAME) ?></span>
		<div id="donate-form">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="KGVN7LJLLZCMY">
			<input type="hidden" name="lc" value="IN">
			<input type="hidden" name="item_name" value="Donation for Where did they go from here?">
			<input type="hidden" name="item_number" value="whergo">
			<strong><?php _e('Enter amount in USD: ',WHEREGO_LOCAL_NAME) ?></strong> <input name="amount" value="10.00" size="6" type="text"><br />
			<input type="hidden" name="currency_code" value="USD">
			<input type="hidden" name="button_subtype" value="services">
			<input type="hidden" name="bn" value="PP-BuyNowBF:btn_donate_LG.gif:NonHosted">
			<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="<?php _e('Send your donation to the author of',WHEREGO_LOCAL_NAME) ?> Where did they go from here?">
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	</div>
  </div>
  
</div>
<?php

}

function wherego_reset() {
	global $wpdb;

	// Delete meta
	$allposts = get_posts('numberposts=0&post_type=post&post_status=');
	foreach( $allposts as $postinfo) {
		delete_post_meta($postinfo->ID, 'wheredidtheycomefrom');
	}
	$allposts = get_posts('numberposts=0&post_type=page&post_status=');
	foreach( $allposts as $postinfo) {
		delete_post_meta($postinfo->ID, 'wheredidtheycomefrom');
	}


}

function wherego_adminmenu() {
	if (function_exists('current_user_can')) {
		// In WordPress 2.x
		if (current_user_can('manage_options')) {
			$wherego_is_admin = true;
		}
	} else {
		// In WordPress 1.x
		global $user_ID;
		if (user_can_edit_user($user_ID, 0)) {
			$wherego_is_admin = true;
		}
	}

	if ((function_exists('add_options_page'))&&($wherego_is_admin)) {
		$plugin_page = add_options_page("Where did they go from here?","Where go", 9, 'wherego_options', 'wherego_options');
		add_action( 'admin_head-'. $plugin_page, 'wherego_adminhead' );
		}
}
add_action('admin_menu', 'wherego_adminmenu');

function wherego_adminhead() {
	global $wherego_url;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $wherego_url ?>/wick/wick.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $wherego_url ?>/admin-styles.css" />
<script type="text/javascript" language="JavaScript">
function checkForm() {
answer = true;
if (siw && siw.selectingSomething)
	answer = false;
return answer;
}//
</script>
<script type="text/javascript" src="<?php echo $wherego_url ?>/wick/sample_data.js.php"></script>
<script type="text/javascript" src="<?php echo $wherego_url ?>/wick/wick.js"></script>
<?php }


/* Display page views on the Edit Posts / Pages screen */
// Add an extra column
function wherego_column($cols) {
	$wherego_settings = wherego_read_options();
	
	if ($wherego_settings[wg_in_admin])	$cols['wherego'] = 'Where go';
	return $cols;
}

// Display page views for each column
function wherego_value($column_name, $id) {
	$wherego_settings = wherego_read_options();
	if (($column_name == 'wherego')&&($wherego_settings[wg_in_admin])) {
		global $wpdb, $post, $single;
		$limit = $wherego_settings['limit'];
		$lpids = get_post_meta($post->ID, 'wheredidtheycomefrom', true);
		if (!is_array($lpids)) $lpids = unserialize($lpids);
		if ($lpids) {
			foreach ($lpids as $lpid) {
				$output .= '<a href="'.get_permalink($lpid).'" title="'.get_the_title($lpid).'">'.$lpid.'</a>, ';
			}
		} else {
			$output = 'None';
		}
		

		echo $output;
	}
}

// Output CSS for width of new column
function wherego_css() {
?>
<style type="text/css">
	#wherego { width: 50px; }
</style>
<?php	
}

// Actions/Filters for various tables and the css output
add_filter('manage_posts_columns', 'wherego_column');
add_action('manage_posts_custom_column', 'wherego_value', 10, 2);
add_filter('manage_pages_columns', 'wherego_column');
add_action('manage_pages_custom_column', 'wherego_value', 10, 2);
add_filter('manage_media_columns', 'wherego_column');
add_action('manage_media_custom_column', 'wherego_value', 10, 2);
add_filter('manage_link-manager_columns', 'wherego_column');
add_action('manage_link_custom_column', 'wherego_value', 10, 2);
add_action('admin_head', 'wherego_css');


?>