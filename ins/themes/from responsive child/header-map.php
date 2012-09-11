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

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 <script type="text/javascript">
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	function initialize() {
		var latlng = new google.maps.LatLng(<?php if (isset($wp_query->query_vars['loc']))
{
the_field('your_location',$wp_query->query_vars['loc']);
}?>);
		directionsDisplay = new google.maps.DirectionsRenderer();
		var myOptions = {
			zoom: 14,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: true
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		directionsDisplay.setMap(map);
		directionsDisplay.setPanel(document.getElementById("directionsPanel"));
		var marker = new google.maps.Marker({
			position: latlng, 
			map: map, 
			title:"<?php
				  $the_query = new WP_Query( 'p='.$wp_query->query_vars['loc'] );
				  $the_query->the_post();
				  the_title();
				  wp_reset_postdata();
				  ?>"
		}); 
	}
	function calcRoute() {
		var start = document.getElementById("routeStart").value;
		var end = "<?php if (isset($wp_query->query_vars['loc']))
{
the_field('your_location',$wp_query->query_vars['loc']);
}?>";
		var request = {
			origin:start,
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			} else {
				if (status == 'ZERO_RESULTS') {
					alert('No route could be found between the origin and destination.');
				} else if (status == 'UNKNOWN_ERROR') {
					alert('A directions request could not be processed due to a server error. The request may succeed if you try again.');
				} else if (status == 'REQUEST_DENIED') {
					alert('This webpage is not allowed to use the directions service.');
				} else if (status == 'OVER_QUERY_LIMIT') {
					alert('The webpage has gone over the requests limit in too short a period of time.');
				} else if (status == 'NOT_FOUND') {
					alert('At least one of the origin, destination, or waypoints could not be geocoded.');
				} else if (status == 'INVALID_REQUEST') {
					alert('The DirectionsRequest provided was invalid.');					
				} else {
					alert("There was an unknown error in your request. Requeststatus: \n\n"+status);
				}
			}
		});
	}
	</script>
</head>

<body <?php body_class(); ?> onLoad="initialize()">
                 
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
