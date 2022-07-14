<?php
//---------------------------------------------------------- //
//	1. Connect to WP database.
//	   Grab CSS values from ACF.
//---------------------------------------------------------- //
include('../../../wp-load.php');
header('Content-type: text/css');
header('Cache-control: must-revalidate');

// ---------------- Main colours ---------------- //
$main_colour = get_field('main_colour', 'options');
$second_colour = get_field('secondary_colour', 'options');

// ---------------- Header ---------------- //
$get_header_bg = get_field('header_bg_colour', 'option');

if($get_header_bg == 'main_colour') {
	$header_bg = $main_colour;
} elseif($get_header_bg == 'secondary_colour') {
	$header_bg = $second_colour;
} else {
	$header_bg = $get_header_bg;	
}

// ---------------- Navigation ---------------- //
$get_nav_bg = get_field('nav_bg_colour', 'option');
$nav_bg = get_field(''.$get_nav_bg.'', 'options');

// ---------------- Header Text ---------------- //
$get_header_text_colour = get_field('header_text_colour', 'option');

if($get_header_text_colour == 'main_colour') {
	$header_text_colour = $main_colour;
} elseif($get_header_text_colour == 'secondary_colour') {
	$header_text_colour = $second_colour;
} else {
	$header_text_colour = $get_header_text_colour;	
}




//---------------------------------------------------------- //
//	2. Include SCSS processor
//	   Docs: http://leafo.net/scssphp/docs/
//---------------------------------------------------------- //
require "modules/scssphp/scss.inc.php";
$scss = new scssc();
$scss->setFormatter(scss_formatter_compressed); // Compress/minify output


//---------------------------------------------------------- //
//	3. Prepare SCSS for compiling
//---------------------------------------------------------- //
echo $scss->compile('
	$main: '.$main_colour.';
	$second: '.$second_colour.';
	$header_bg: '.$header_bg.';
	$nav_bg: '.$nav_bg.';
	$header_text_colour: '.$header_text_colour.';
	
	/* Header */
	.header { background:$header_bg;}
	#primary-nav { background:$nav_bg;}

	.phone { color:$header_text_colour;}

	.topbar { 
		.social { 
			ul { 
				li {
					a { background:$header_text_colour;}
				}
			}
		}
	}
');
?>