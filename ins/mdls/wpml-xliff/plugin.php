<?php 
/*
Plugin Name: WPML XLIFF
Plugin URI: http://wpml.org/
Description: Import and Export XLIFF files for translation
Author: ICanLocalize
Author URI: http://wpml.org
Version: 0.9.1
*/

if(defined('WPML_XLIFF_VERSION')) return;

define('WPML_XLIFF_VERSION', '0.9.1');
define('WPML_XLIFF_PATH', dirname(__FILE__));

require WPML_XLIFF_PATH . '/inc/constants.inc';
require WPML_XLIFF_PATH . '/inc/wpml_xliff.class.php';

$WPML_xliff = new WPML_xliff();
?>
