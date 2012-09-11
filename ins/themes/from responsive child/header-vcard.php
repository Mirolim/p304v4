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
<script src='http://maps.googleapis.com/maps/api/js?sensor=false' type='text/javascript'></script>
<link rel='stylesheet' id='responsive-style-css'  href='http://192.168.1.101/p304/wp-content/themes/responsive-child/style-vcard.css?ver=1.2.0' type='text/css' media='all' />
<script src='http://maps.googleapis.com/maps/api/js?sensor=false' type='text/javascript'></script>
<?php wp_head(); ?>
<script>
 jQuery(document).ready(function() {	
	 jQuery(".vcard-section").toggle(); 
	 jQuery(".vcard-btn").click(function () {
		 var current_section = jQuery(this).attr('id');
		 jQuery(".vcard-btn").each(function (){
		 	jQuery(this).removeClass('active-tab');
		 });
		 jQuery(this).addClass('active-tab');
		switch ( current_section )
		{
			case "resume-btn":
			 jQuery("#vcard-contactme").slideUp(); 
			 jQuery("#vcard-portfolio").slideUp();
			 jQuery("#vcard-resume").slideDown();
			 break;
			case "portfolio-btn":
			 jQuery("#vcard-contactme").slideUp();
			 jQuery("#vcard-resume").slideUp();
			 jQuery("#vcard-portfolio").slideDown();
			 break;
			case "contact-btn":
			 jQuery("#vcard-resume").slideUp();
			 jQuery("#vcard-portfolio").slideUp();
			 jQuery("#vcard-contactme").slideDown();
			  <?php
$location = get_field('your_location');
$temp = explode(',', $location);
$lat = (float) $temp[0];
$lng = (float) $temp[1];
?>
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
			 break;
		}
	 });
	 jQuery(".vcard-btn").hover(function () {
		jQuery(this).css('color','orange');
	 }, function () {
	 	jQuery(this).css('color','#666');
	 });
 });
</script>
</head>

<body <?php body_class(); ?>>
<div id="container" class="hfeed">
         
    <div id="header">

  		<div id="your_name">
          
        </div><!-- end of #logo -->
        <div class="grid col-940">
    
       	 <div class="grid col-620">
			
         </div><!-- end of col-620 -->
         <div class="grid col-300 fit">
         <?php $options = get_option('responsive_theme_options');
					
            // First let's check if any of this was set
		
                echo '<ul class="social-icons">';
                if ($options['twitter_uid']) echo '<li class="twitter-icon"><a href="' . $options['twitter_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/twitter-icon.png" alt="Twitter">'
                    .'</a></li>';

                if ($options['facebook_uid']) echo '<li class="facebook-icon"><a href="' . $options['facebook_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/facebook-icon.png" alt="Facebook">'
                    .'</a></li>';
  
                if ($options['linkedin_uid']) echo '<li class="linkedin-icon"><a href="' . $options['linkedin_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/linkedin-icon.png" alt="LinkedIn">'
                    .'</a></li>';
					
                if ($options['youtube_uid']) echo '<li class="youtube-icon"><a href="' . $options['youtube_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/youtube-icon.png" alt="YouTube">'
                    .'</a></li>';
					
                if ($options['stumble_uid']) echo '<li class="stumble-upon-icon"><a href="' . $options['stumble_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/stumble-upon-icon.png" alt="YouTube">'
                    .'</a></li>';
					
                if ($options['rss_uid']) echo '<li class="rss-feed-icon"><a href="' . $options['rss_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/rss-feed-icon.png" alt="RSS Feed">'
                    .'</a></li>';
       
                if ($options['google_plus_uid']) echo '<li class="google-plus-icon"><a href="' . $options['google_plus_uid'] . '">'
                    .'<img src="' . get_stylesheet_directory_uri() . '/icons/googleplus-icon.png" alt="Google Plus">'
                    .'</a></li>';
             
                echo '</ul><!-- end of .social-icons -->';
         ?>
         </div><!-- end of col-300 fit -->
        </div><!-- end of col-940 -->
     </div><!-- end of #header -->
     <div id="wrapper" class="clearfix grid col-780 fit">