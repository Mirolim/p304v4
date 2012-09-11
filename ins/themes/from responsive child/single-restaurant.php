<?php
/*
Template Name Posts: Restaurant
@author         Emil Uzelac modified by Mirolim FGL
*/
?>
<?php get_header('restaurant'); ?>

        <div id="content" class="grid col-940">
        
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        
        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php echo responsive_breadcrumb_lists(); ?>
        <?php endif; ?>
        <script type="text/javascript">

		  var wdt = document.getElementById("content").width;
		  var hgt = window.screen.availHeight*0.27;  
		  var mygallery=new fadeSlideShow({
			  wrapperid: "slideshow", //ID of blank DIV on page to house Slideshow
			  dimensions: [wdt,hgt], //width/height of gallery in pixels. Should reflect dimensions of largest image
			  imagearray:[["<?php the_field('first_image_for_slider');?>", "", "", "<?php the_field('short_text_1');?>"],["<?php the_field('second_image_for_slider');?>", "", "", "<?php the_field('short_text_2');?>"],["<?php the_field('third_image_for_slider');?>", "", "", "<?php the_field('short_text_3');?>"]], //<--no trailing comma after very last image element!
			  displaymode: {type:'auto', pause:5500, cycles:0, wraparound:false},
			  persist: false, //remember last viewed slide and recall within same session?
			  fadeduration: 500, //transition duration (milliseconds)
			  descreveal: "ondemand",
			  togglerid: ""
		  })
		  
		</script> 
          	<div id="slideshow" class="grid col-940"></div>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>

                <div class="post-meta">
                <?php 
                    printf( __( '<span class="%1$s">Posted on</span> %2$s by %3$s', 'responsive-child' ),'meta-prep meta-prep-author',
		            sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
			            get_permalink(),
			            esc_attr( get_the_time() ),
			            get_the_date()
		            ),
		            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			            get_author_posts_url( get_the_author_meta( 'ID' ) ),
			        sprintf( esc_attr__( 'View all posts by %s', 'responsive-child' ), get_the_author() ),
			            get_the_author()
		                )
			        );
		        ?>
				    <?php if ( comments_open() ) : ?>
                        <span class="comments-link">
                        <span class="mdash">&mdash;</span>
                    <?php comments_popup_link(__('No Comments &darr;', 'responsive-child'), __('1 Comment &darr;', 'responsive-child'), __('% Comments &darr;', 'responsive-child')); ?>
                        </span>
                    <?php endif; ?> 
                </div><!-- end of .post-meta -->
                                
                <div class="post-entry">
                    <div id="com_desc" class="grid col-940 fit"><?php the_content(__('Read more &#8250;', 'responsive-child')); ?>
                    
                    <?php if ( get_the_author_meta('description') != '' ) : ?>
                    
                    <div id="author-meta">
                    <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>
                        <div class="about-author"><?php _e('About','responsive-child'); ?> <?php the_author_posts_link(); ?></div>
                        <p><?php the_author_meta('description') ?></p>
                    </div><!-- end of #author-meta -->
                    
                    <?php endif; // no description, no author's meta ?>
                    
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive-child'), 'after' => '</div>')); ?>
                     <div id="download_menu"><a href="<?php the_field('file'); ?>"  class="link_restaurant_menu" title="Download Menu"><strong><?php the_field('description_file');?></strong></a></div>
                    </div>
                   <div id="block_one" class="grid col-940 fit"> 
                    <div id="contact_info" class="grid col-300">
                        <div id="working_hrs" ><h4><?php _e('Working Hours','responsive');?></h4><?php the_field('working_hours'); ?></div>
                    	<div id="main_phone_number"><strong>Phone number:</strong><a href="tel:<?php the_field('main_phone_number');?>"><?php the_field('main_phone_number');?></a></div>
                        <div id="book_tbl"><strong><?php _e('Book table','responsive');?>:</strong><a href="tel:<?php the_field('book_table'); ?>"><?php the_field('book_table'); ?></a></div>
                        <div id="order_dlvr"><strong><?php _e('Order Delivery','responsive');?>:</strong><?php the_field('order_delivery'); ?></div>
                        <div id="cont_email"><strong>Email:</strong><?php the_field('main_contact_email'); ?></div>
                        <div id="other_cont"><strong><?php _e('Other contacts','responsive');?>:</strong><br /><?php the_field('other_contacts'); ?></div>
                        <div id="addrss"><strong><?php _e('Address','responsive');?>:</strong><?php the_field('your_address'); ?></div>
                    </div>
                    <div id="geo_position" class="grid col-300"><h4><?php _e('Location','responsive-child');?></h4><div id="map" style="width: 16em; height: 18em;"></div>
                    	<a href="<?php bloginfo('url');?>/get-directions/?loc=<?php the_ID()?>">View Larger Map/Directions</a><br />
                        <a href="<?php bloginfo('url');?>/find-nearby/?loc=<?php the_ID()?>">Find nearby Places</a>
                    </div>
                                        <div id="about_us" class="grid col-300 fit"><h4><?php _e('About Us','responsive-child');?></h4><?php the_field('brief_description'); ?></div>
                   </div>
                    <div id="block_two" class="grid col-940 fit"><h4><?php _e('Today specials','responsive-child');?></h4>
                    	<div class="grid col-300"><image src="<?php $image = wp_get_attachment_image_src(get_field('picture_of_the_first_dish'), 'Thumbnail'); echo $image[0]; ?>"  /><br /><div><?php the_field('first_dish'); ?></div></div>
                   	 	<div class="grid col-300"><image src="<?php $image = wp_get_attachment_image_src(get_field('picture_of_the_second_dish'), 'Thumbnail'); echo $image[0]; ?>"  /><br /><div><?php the_field('second_dish'); ?></div></div>
                  	  	<div class="grid col-300 fit"><image src="<?php $image = wp_get_attachment_image_src(get_field('picture_of_the_third_dish'), 'Thumbnail'); echo $image[0]; ?>"  /><br /><div><?php the_field('third_dish'); ?></div></div>
                  	</div>
                    <div id="block_three" class="grid col-940 fit">
                    <div id="attr_bussiness" class="grid col-300">
                    	<h4>Attributes?</h4>
                        <strong>Parking: </strong><?php the_field('parking'); ?><br />
                    	<strong>Good for kids: </strong><?php the_field('good_for_kids'); ?><br />
                        <strong>Accepts credit cards: </strong><?php the_field('accepts_credit_cards'); ?><br />
                        <strong>Attire: </strong><?php the_field('attire'); ?><br />
                        <strong>Good for groups: </strong><?php the_field('good_for_groups'); ?><br />
                        <strong>Price range: </strong><?php the_field('price_range'); ?><br />
                        <strong>Take-out: </strong><?php the_field('take_out'); ?><br />
                        <strong>Cater: </strong><?php the_field('cater'); ?><br />
                        <strong>Waiter service: </strong><?php the_field('waiter_service'); ?><br />
                        <strong>Outdoor seating: </strong><?php the_field('outdoor_seating'); ?><br />
                        <strong>Wi-fi: </strong><?php the_field('wi_fi'); ?><br />
                        <strong>Good for: </strong><?php the_field('good_for'); ?><br />
                        <strong>Alcohol: </strong><?php the_field('alcohol'); ?><br />
                        <strong>Noise level: </strong><?php the_field('noise_level'); ?><br />
                        <strong>Ambience: </strong><?php the_field('ambience'); ?><br />
                        <strong>Has TV: </strong><?php the_field('has_tv'); ?><br />
                        <strong>Wheelchair accessible: </strong><?php the_field('wheelchair_accessible'); ?><br />
                    </div>
                    <div id="events" class="grid col-300"><h4>Events</h4>
                 		<div><strong><?php the_field('1-_event'); ?></strong></div>
                    	<div>Период акции {<?php the_field('1e_start'); ?>-<?php the_field('1e_end'); ?>}</div>
                   		<div><strong><?php the_field('2-_event'); ?></strong></div>
                    	<div>Период акции {<?php the_field('2e_start'); ?>-<?php the_field('2e_end'); ?>}</div>
                    </div>
                   	<div id="sales" class="grid col-300 fit"><h4>Sales</h4>
                        <div><strong><?php the_field('1-_sale'); ?></strong></div>
                        <div>Период акции {<?php the_field('1-_start'); ?>-<?php the_field('1-_end'); ?>}</div>
                        <div><strong><?php the_field('2-_sale'); ?></strong></div>
                        <div>Период акции {<?php the_field('2-_start'); ?>-<?php the_field('2-_end'); ?>}</div>
                    </div>   
                   </div>                        
<?php
$location = get_field('your_location');
$temp = explode(',', $location);
$lat = (float) $temp[0];
$lng = (float) $temp[1];
?>
<script type="text/javascript">
//<![CDATA[
function load() {
var lat = <?php echo $lat; ?>;
var lng = <?php echo $lng; ?>;
// coordinates to latLng
var latlng = new google.maps.LatLng(lat, lng);
// map Options
var myOptions = {
zoom: 15,
center: latlng,
mapTypeId: google.maps.MapTypeId.ROADMAP
};
//draw a map
var map = new google.maps.Map(document.getElementById("map"), myOptions);
var marker = new google.maps.Marker({
position: map.getCenter(),
map: map
});
}
// call the function
load();
//]]>
</script>

<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
</div>
                </div><!-- end of .post-entry -->
                
                <div class="post-data">
				    <?php the_tags(__('Tagged with:', 'responsive-child') . ' ', ', ', '<br />'); ?> 
					<?php printf(__('Posted in %s', 'responsive-child'), get_the_category_list(', ')); ?> 
                </div><!-- end of .post-data -->             

            <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive-child')); ?></div>             
            </div><!-- end of #post-<?php the_ID(); ?> -->
            
			<?php comments_template( '', true ); ?>
            
        <?php endwhile; ?> 

        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive-child' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive-child' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive-child'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive-child'); ?></p>
        <h6><?php _e( 'You can return', 'responsive-child' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive-child' ); ?>"><?php _e( '&#9166; Home', 'responsive-child' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive-child' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>  
      
        </div><!-- end of #content -->

<?php get_footer('restaurant'); ?>

