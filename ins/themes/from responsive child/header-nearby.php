<?php
/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive 
 * @author         Emil Uzelac modified by Mirolim FGL
 * @copyright      2003 - 2012 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title><?php wp_title('&#124;', true, 'right'); ?><?php bloginfo('name'); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--<link href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic,700italic" rel="stylesheet" type="text/css">-->

<?php wp_enqueue_style('responsive-style', get_stylesheet_uri(), false, '1.2.0');?>
<?php wp_head(); ?>
  <script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyAWhUeQ5QhW9Cul-O_z4OsTVa9IfAz78F8"
            type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[
    var map;
    var geocoder;
    function load() {
      if (GBrowserIsCompatible()) {
        geocoder = new GClientGeocoder();
        map = new GMap2(document.getElementById('map'));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(41.29298720241262, 69.25906777381897), 12);
      }
    }

   function searchLocations() {
     var address = document.getElementById('addressInput').value;
	 var loc = '<?php if (isset($wp_query->query_vars['loc'])){the_field('your_location',$wp_query->query_vars['loc']);} else { echo '';}?>';
	 if ( loc !='') {
		 searchLocationsNear(loc);
	 } else {
     geocoder.getLatLng(address, function(latlng) {
       if (!latlng) {
         alert(address + ' not found');
       } else {
         searchLocationsNear(latlng);
       	}
       });
	 }
   }

   function searchLocationsNear(center) {
     var radius = document.getElementById('radiusSelect').value;
     var searchUrl = 'http://192.168.1.101/p304/map-markers/?loc='+<?php if (isset($wp_query->query_vars['loc'])){ echo $wp_query->query_vars['loc'];}?>+'&radius=' + radius;
     GDownloadUrl(searchUrl, function(data,responseCode) {
		  // To ensure against HTTP errors that result in null or bad data,
  // always check status code is equal to 200 before processing the data
  if(responseCode == 200) {
       var xml = GXml.parse(data);
       var markers = xml.documentElement.getElementsByTagName('marker');
       map.clearOverlays();
       var sidebar = document.getElementById('sidebar');
       sidebar.innerHTML = '';
       if (markers.length == 0) {
         sidebar.innerHTML = 'No results found.';
         map.setCenter(new GLatLng(41.29298720241262, 69.25906777381897), 12);
         return;
       }
       var bounds = new GLatLngBounds();
       for (var i = 0; i < markers.length; i++) {
         var name = markers[i].getAttribute('name');
		 var address = markers[i].getAttribute('address');
		 var comlogo = markers[i].getAttribute('comlogo');
		 var postid = markers[i].getAttribute('postid');
         var distance = parseFloat(markers[i].getAttribute('distance'));
         var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
                                 parseFloat(markers[i].getAttribute('lng')));
         
         var marker = createMarker(point, name,address,comlogo);
         map.addOverlay(marker);
         var sidebarEntry = createSidebarEntry(marker, name, distance,comlogo,postid);
         sidebar.appendChild(sidebarEntry);
         bounds.extend(point);
       }
       map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
  } else if(responseCode == -1) {
    alert("Data request timed out. Please try later.");
  } else { 
    alert("Request resulted in error. Check XML file is retrievable.");
  }
     });
   }

    function createMarker(point, name,address,comlogo) {
      var marker = new GMarker(point);
      var html = '<strong>' + name + '</strong><br /><img src="'+comlogo+'" style="width:150px" /><br/>' + address;
      GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(html);
      });
	  GEvent.addListener(marker, "mouseout", function() {
		map.closeInfoWindow();
 		}); 
      return marker;
    }

    function createSidebarEntry(marker, name, distance,comlogo,postid) {
      var div = document.createElement('div');
      var html = '<img src="'+comlogo+'" style="width:200px"/><br /><a href="<?php bloginfo('url');?>/?p='+ postid +'"><strong>' + name + '</strong></a> (' + distance.toFixed(1) + ' km)<br/>';
      div.innerHTML = html;
	  div.style.marginBottom = '5px'; 
      GEvent.addDomListener(div, 'mouseover', function() {
        GEvent.trigger(marker, 'click');
      });
      GEvent.addDomListener(div, 'mouseover', function() {
        div.style.backgroundColor = '#eee';
      });
      GEvent.addDomListener(div, 'mouseout', function() {
		 GEvent.trigger(marker, 'mouseout');
		div.style.backgroundColor = '#fff';
		
      });
      return div;
    }
    //]]>
  </script>

</head>

<body <?php body_class(); ?> onLoad="load(),searchLocations()" onUnload="GUnload()">
                 
<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed">
         
    <?php responsive_header(); // before header hook ?>
    <div id="header">
    
        <?php if (has_nav_menu('top-menu', 'responsive-child')) { ?>
	        <?php wp_nav_menu(array(
				    'container'       => '',
					'menu_class'      => 'top-menu',
					'theme_location'  => 'top-menu')
					); 
				?>
        <?php } ?>
        
    <?php responsive_in_header(); // header hook ?>
   
	<?php if ( get_header_image() != '' ) : ?>
               
        <div id="logo">
            <a href="<?php echo home_url( '/' ); ?>"><img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="<?php bloginfo('description'); ?>" /></a>
        </div><!-- end of #logo -->
        
    <?php endif; // header image was removed ?>

    <?php if ( !get_header_image() ) : ?>
                
        <div id="logo">
            <span class="site-name"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></span>
            <span class="site-description"><?php bloginfo('description'); ?></span>
        </div><!-- end of #logo -->  

    <?php endif; // header image was removed (again) ?>
			    
				<?php wp_nav_menu(array(
				    'container'       => '',
					'theme_location'  => 'header-menu')
					); 
				?>
                
            <?php if (has_nav_menu('sub-header-menu', 'responsive-child')) { ?>
	            <?php wp_nav_menu(array(
				    'container'       => '',
					'menu_class'      => 'sub-header-menu',
					'theme_location'  => 'sub-header-menu')
					); 
				?>
            <?php } ?>
 
    </div><!-- end of #header -->
    <?php responsive_header_end(); // after header hook ?>
    
	<?php responsive_wrapper(); // before wrapper ?>
    <div id="wrapper" class="clearfix">
    <?php responsive_in_wrapper(); // wrapper hook ?>
