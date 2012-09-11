  <?php
  /*
Template Name: Filter Result Page
@author         Mirolim FGL
*/
?>
         <div style="display:none;" id="dvloader"><img src="<?php echo get_template_directory_uri(); ?>/img/yalp-loading.gif" /></div>
<?php
  if (isset($wp_query->query_vars['cusine_types'])) { 
					$tax_cusine_types = array ('taxonomy' => 'cusine_types','field' => 'slug', 'terms' => $wp_query->query_vars['cusine_types']);

				}
				if (isset($wp_query->query_vars['neighborhoods'])) {
					$tax_neighborhoods = array ('taxonomy' => 'neighborhoods','field' => 'slug', 'terms' => $wp_query->query_vars['neighborhoods']);

				}

				if (isset($wp_query->query_vars['price_range'])) {
					$tax_price_range= array ('taxonomy' => 'price_range','field' => 'slug', 'terms' => $wp_query->query_vars['price_range']);
				}

				$args = array(
					'tax_query' => array(
						'relation' => 'AND',
						$tax_cusine_types,
						$tax_neighborhoods,
						$tax_price_range
					)
				);
    $query = new WP_Query( $args );
    while ( $query->have_posts() ) : $query->the_post();?>
    <a href="<?php the_permalink();?>">
    <?php the_title(); ?></a>
    <?php 
    echo '<div class="entry-content">';
    the_content();
	$lanlng .= '{latlng : new google.maps.LatLng('.get_field('your_location').')},';
    echo '</div>';
    endwhile;
    wp_reset_postdata();
	?>
    <script type="text/javascript">
       var locations = [
                   <?php echo $lanlng; ?>
       ];
    </script>
<div id="map" style="width: 800px; height: 300px;"></div>
