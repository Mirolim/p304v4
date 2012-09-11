<?php
/*
	Template Name: Frontend Edit Page
*/
?>
<?php

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {
	// Do some minor form validation to make sure there is content
	if (isset ($_POST['title'])) {
		$title =  $_POST['title'];
	} else {
		echo __('Please enter the wine name','twentyeleven');
	}
	if (isset ($_POST['description'])) {
		$description = $_POST['description'];
	} else {
		echo __('Please enter some notes','twentyeleven');
	}

	$tags = $_POST['post_tags'];
	$winerating = $_POST['winerating'];
 
	// ADD THE FORM INPUT TO $new_post ARRAY
	$new_post = array(
	'post_title'	=>	$title,
	'post_content'	=>	$description,
	//'post_category'	=>	array($_POST['cat']),  // Usable for custom taxonomies too
	'tags_input'	=>	array($tags),
	'post_status'	=>	'pending',           // Choose: publish, preview, future, draft, etc.
	'post_type'	=>	array($_POST['pst']),  //'post',page' or use a custom post type if you want to
	'winerating'	=>	$winerating
	);

	//SAVE THE POST
	$pid = wp_insert_post($new_post);

             //KEEPS OUR COMMA SEPARATED TAGS AS INDIVIDUAL
	wp_set_post_tags($pid, $_POST['post_tags']);

	//REDIRECT TO THE NEW POST ON SAVE
	$link = get_permalink( $pid );
	wp_redirect( $link );

	//ADD OUR CUSTOM FIELDS 
	add_post_meta($pid, 'rating', $winerating, true); 

	//INSERT OUR MEDIA ATTACHMENTS
	if ($_FILES) {
		foreach ($_FILES as $file => $array) {
		$newupload = insert_attachment($file,$pid);
		// $newupload returns the attachment id of the file that
		// was just uploaded. Do whatever you want with that now.
		}

	} // END THE IF STATEMENT FOR FILES

} // END THE IF STATEMENT THAT STARTED THE WHOLE FORM

//POST THE POST YO
do_action('wp_insert_post', 'wp_insert_post');

?>

<?php get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php } ?>

					<div class="form-content">
						<?php the_content(); ?>

		<!-- WINE RATING FORM -->

		<div class="wpcf7">
		<form id="new_post" name="new_post" method="post" action="" class="wpcf7-form" enctype="multipart/form-data">
			<!-- post name -->
			<fieldset name="name">
				<label for="title"><?php echo __('Title','twentyeleven'); ?></label>
				<input type="text" id="title" value="" tabindex="5" name="title" />
			</fieldset>

			<!-- post Category -->
			<fieldset class="post_type">
				<label for="pst"><?php echo __('Type','twentyeleven');?>:</label>
				<?php 
				// Custom post type selection
				$args=array(
				  'public'   => true,
				  '_builtin' => false
				); 
				$output = 'names'; // names or objects, note names is the default
				$operator = 'and'; // 'and' or 'or'
				$post_types=get_post_types($args,$output,$operator); 
				echo '<select id="pst" class="postform" tabindex="10" name="pst">';
				  foreach ($post_types  as $post_type ) {
					echo '<option value="'. $post_type. '">'.$post_type.'</option>';
				  }
				 echo '</select>';
				   ?>
			</fieldset>

			<!-- post Content -->
			<fieldset class="content">
				<label for="description"><?php echo __('Content','twentyeleven');?>:</label>
				<textarea id="description" tabindex="15" name="description" cols="80" rows="10"></textarea>
			</fieldset>

			<!-- wine Rating -->
			<fieldset class="winerating">
				<label for="winerating">Your Rating</label>
				<input type="text" value="" id="winerating" tabindex="20" name="winerating" />
			</fieldset>

			<!-- images -->
			<fieldset class="images">
				<label for="bottle_front">Front of the Bottle</label>
				<input type="file" name="bottle_front" id="bottle_front" tabindex="25" />
			</fieldset>

			<fieldset class="images">
				<label for="bottle_rear">Back of the Bottle</label>
				<input type="file" name="bottle_rear" id="bottle_rear" tabindex="30" />
			</fieldset>

			<!-- post tags -->
			<fieldset class="tags">
				<label for="post_tags">Additional Keywords (comma separated):</label>
				<input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
			</fieldset>

			<fieldset class="submit">
				<input type="submit" value="Post Review" tabindex="40" id="submit" name="submit" />
			</fieldset>

			<input type="hidden" name="action" value="new_post" />
			<?php wp_nonce_field( 'new-post' ); ?>
		</form>
		</div> <!-- END WPCF7 -->

		<!-- END OF FORM -->
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #container -->
<?php get_footer(); ?>