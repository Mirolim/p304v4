<?php
/*
Template Name: Map Markers Page
@author         Mirolim FGL
*/
?>
<?php  
// Get parameters from URL
if (isset($wp_query->query_vars['loc']))
{
$loc = $wp_query->query_vars['loc'];
$latlng = get_field('your_location',$wp_query->query_vars['loc']);
}
$location = explode(",", $latlng);
$center_lat = $location[0];
$center_lng = $location[1];

if (isset($wp_query->query_vars['radius']))
{
$radius = $wp_query->query_vars['radius'];
} else {
	$radius = 20;
}
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Search the rows in the markers table

$query = sprintf("SELECT post_id,meta_value, SUBSTRING_INDEX (meta_value,',',1) AS lat, SUBSTRING_INDEX (meta_value,',',-1) AS lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( SUBSTRING_INDEX (meta_value,',',1) ) ) * cos( radians( SUBSTRING_INDEX (meta_value,',',-1) ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( SUBSTRING_INDEX (meta_value,',',1) ) ) ) ) AS distance FROM wp_postmeta WHERE post_id = ANY (SELECT post_id FROM wp_postmeta WHERE meta_key = (SELECT meta_key FROM wp_postmeta WHERE post_id = '%s' AND (meta_key='lang-en_us' OR meta_key='lang-ru_ru') ) ) HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($loc),
  mysql_real_escape_string($radius));
$result = mysql_query($query);

if (!$result) {
  die("Invalid query: " . mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $the_query = new WP_Query( 'p='.$row['post_id']);
  $the_query->the_post();
  $newnode->setAttribute("name", get_the_title());
  $newnode->setAttribute("address", get_field('your_address',$row['post_id']));
  $newnode->setAttribute("comlogo", get_field('your_logo',$row['post_id']));
  $newnode->setAttribute("postid", $row['post_id']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();
?>
