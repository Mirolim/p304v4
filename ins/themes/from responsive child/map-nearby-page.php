<?php
/*
Template Name: Map Nearby Page
@author         Mirolim FGL
*/
?>
<?php get_header('nearby'); ?>
   
        <div id="content-full" class="grid col-940">
        
<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
        
        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php echo responsive_breadcrumb_lists(); ?>
        <?php endif; ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php 
				the_title();
				$the_query = new WP_Query( 'p='.$wp_query->query_vars['loc'] );
				  echo  ' to <a href="';
				  bloginfo('url');
				  echo '/?p='.$wp_query->query_vars['loc'].'">';
				  echo '<span style="color:blue">';
				  $the_query->the_post();
				  the_title();
				  echo '</span></a>';
								 wp_reset_postdata();
				  ?></h1>
 				<!-- end of #post-<?php the_ID(); ?> -->
              <div class="post-entry">
                    <?php the_content(__('Read more &#8250;', 'responsive')); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->
        <?php endwhile; ?>         
		<div id="find_nearby">
        	<div id="attr_bar" class="grid col-940 fit" style="background-color:#EAEAEA;">
            <center style="margin-top:1em;">
              <div id="att_addrs" class="grid col-460"><label>Address: &nbsp;<input type="text" id="addressInput"/></label></div>
              <div id="att_attr" class="grid col-220">
              <label>Radius:&nbsp; <select id="radiusSelect">
              <option value="1">1km</option>
              <option value="5" selected="selected">5km</option>  
              <option value="10">10km</option>
             </select>
             </label>
             </div>
             <div id="att_srch" class="grid col-220 fit">
             <input type="button" onclick="searchLocations()" value="Search Locations"/>
             </div>
             </center>
         	</div>
            <div id="nearby_places_block" class="grid col-940 fit">
            	<div class="grid col-220">
					<div id="sidebar" style="overflow: auto; height: 100%; font-size: 11px; color: #000"></div> 
                </div>
                <div class="grid col-700 fit">    
         	   		<div id="map" style="overflow: hidden; width:100%;height:400px;"></div>   
                </div>
            </div> 
        </div>
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&#9166; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>  
      
        </div><!-- end of #content-full -->

<?php get_footer(); ?>