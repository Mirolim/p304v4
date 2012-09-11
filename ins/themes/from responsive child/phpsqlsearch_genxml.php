<?php  
// Get parameters from URL
if (isset($wp_query->query_vars['loc']))
{
$latlng = get_field('your_location',$wp_query->query_vars['loc']);
}
$latlng = explode(",", $latlng);
$center_lat = $latlng[0];
$center_lng = $latlng[1];
if (isset($wp_query->query_vars['radius']))
{
$radius = $wp_query->query_vars['radius'];
} else {
	$radius = 1;
}

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a mySQL server
/*$connection=mysql_connect (localhost, $username, $password);
if (!$connection) {
  die("Not connected : " . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ("Can\'t use db : " . mysql_error());
}*/

// Search the rows in the markers table
$query = sprintf("SELECT post_id,meta_value, SUBSTRING_INDEX ('meta_value',',',1) AS lat, SUBSTRING_INDEX ('meta_value',',',-1) AS lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM wp_postmeta HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
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
  $newnode->setAttribute("name", $row['post_id']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("distance", $row['distance']);
}

echo $dom->saveXML();
?>
