<?php
/*
	Template Name: Restaurant Page
*/
get_header(); ?>
<script type="text/javascript">
var infowindow = new google.maps.InfoWindow();
var pinkmarker = new google.maps.MarkerImage('/p304v3/img/pink_Marker.png', new google.maps.Size(37, 34) );
var shadow = new google.maps.MarkerImage('/p304v3/img/shadow.png', new google.maps.Size(37, 34) );

	    function initialize() {
		  var map = new google.maps.Map(document.getElementById('map'), { 
			  zoom: 12, 
			  mapTypeId: google.maps.MapTypeId.ROADMAP 
		  });
		  var bounds = new google.maps.LatLngBounds();
			for (var i = 0; i < locations.length; i++) {  
			var marker = new google.maps.Marker({
	    	position: locations[i].latlng,
			icon: pinkmarker,
			shadow: shadow,
			map: map
			});
			bounds.extend(locations[i].latlng);
   			map.fitBounds(bounds);
			}		
			var listener = google.maps.event.addListenerOnce(map, "idle", function() { 
			  if (map.getZoom() > 16) map.setZoom(16); });	
	 };
	jQuery(document).ready(function () {	  	  
		jQuery('input').click(function () {
		// Get all the forms elements and their values in one step
			var values = $('#filter_options').serialize();	
			jQuery("#dvloader").show();	
			jQuery.ajax({
				//Manually change script address
			  url: '<?php $site = explode('?',get_bloginfo('url')); echo $site[0]?>/filter-result-2/?'+values+'<?php echo '&'.$site[1]?>',
			  success: function(data) {
				jQuery("#dvloader").hide(); 
				jQuery('#filter_list').html(data);
				initialize();
			  }
		  });
		})
	});
</script>
		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
					<?php	
					echo '<div id="filter_form"><form id="filter_options">';
			  $args = array( 'taxonomy' => 'cusine_types' );
			  
			  $terms = get_terms('cusine_types', $args);
			  
			  $count = count($terms); $i=0;
			  if ($count > 0) {
				echo "<ul><strong>".__('Кухня','twentyeleven-child')."</strong>";
			   foreach ( $terms as $term ) {
				 echo "<li><input name='cusine_types[]' type='checkbox' value='".$term->slug."'/ >" . $term->name . "</li>";
				  
			   }
			   echo "</ul>";
			  }
			  $args = array( 'taxonomy' => 'neighborhoods' );
			  
			  $terms = get_terms('neighborhoods', $args);
			  
			  $count = count($terms); $i=0;
			  if ($count > 0) {
				 echo "<ul><strong>".__('Район','twentyeleven-child')."</strong>";
			   foreach ( $terms as $term ) {
				 echo "<li><input name='neighborhoods[]' type='checkbox' value='".$term->slug."'/ >" . $term->name . "</li>";
				  
			   }
			   echo "</ul>";
			  }
			  $args = array( 'taxonomy' => 'price_range' );
			  
			  $terms = get_terms('price_range', $args);
			  
			  $count = count($terms); $i=0;
			  if ($count > 0) {
			   echo "<ul><strong>".__('Цены','twentyeleven-child')."</strong>";
   				foreach ( $terms as $term ) {
				 echo "<li><input name='price_range[]' type='checkbox' value='".$term->slug."'/ >" . $term->name . "</li>";
        
				}
			  echo "</ul>";
			  }
			 echo '</form></div>';		?>
				<?php endwhile; // end of the loop. ?>
			<div id="filter_list">
                        <div style="display:none;" id="dvloader"><img src="<?php echo get_template_directory_uri(); ?>/img/yalp-loading.gif" /></div>
            </div>
			</div><!-- #content -->
		</div><!-- #primary -->
	    <?php ?>
<?php get_footer(); ?>