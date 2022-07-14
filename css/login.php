<?php
/*
	Custom Login
	Author: FL1 Digital - www.fl1doigital.com
	Description: Style WordPress login page
*/

//---------------------------------------------------------- //
//	1. Connect to WP database.
//	   Grab CSS values from ACF.
//---------------------------------------------------------- //
include('../../../../wp-load.php');
header('Content-type: text/css');
header('Cache-control: must-revalidate');

// Logo
$get_logo_id = get_field('logo', 'option');
$logo = vt_resize($get_logo_id,'' , 550, 142, false);

// Colours
$main_colour = get_field('main_colour', 'option');
$second_colour = get_field('secondary_colour', 'option');

$get_text_colour = get_field('login_text_colour', 'option');

if($get_text_colour == 'main_colour') {
	$text = $main_colour;
} elseif($get_text_colour == 'secondary_colour') {
	$text = $second_colour;
} else {
	$text = $get_text_colour;	
}

// Background
if(get_field('login_bg_img', 'option')) {

	// Background image
	$get_bgimg_id = get_field('login_bg_img', 'option');
	$bgimg = vt_resize($get_bgimg_id,'' , 1500, 500, false);

	$background = 'url('.$bgimg[url].') no-repeat center top / cover;';

} else {

	// Background colour
	if(get_field('login_bg', 'options')) {
		$get_background = get_field('login_bg', 'option');
		$background = get_field(''.$get_background.'', 'option');
	} else {
		$background = '#f1f1f1';
	}
}

//---------------------------------------------------------- //
//	2. Include SCSS processor
//	   Docs: http://leafo.net/scssphp/docs/
//---------------------------------------------------------- //
require "../modules/scssphp/scss.inc.php";
$scss = new scssc();
$scss->setFormatter(scss_formatter_compressed); // Compress/minify output


//---------------------------------------------------------- //
//	3. Prepare SCSS for compiling
//---------------------------------------------------------- //
echo $scss->compile('
	$main: '.$main_colour.';
	$second: '.$second_colour.';
	$text: '.$text.';
	$background: '.$background.';

	body.login { min-height:600px; background:$background;
		#nav { color:$text !important;
			a { color:$text !important; text-decoration:none !important;
				&:hover { color:$text !important; text-decoration:underline !important;}
			}
		}

		h1 a { background:url('.$logo[url].') no-repeat scroll center; background-size:95%; display:block; margin:0 auto 20px; width:225px; padding:0;}

		#backtoblog { 
			a { color:$text !important; text-decoration:none;
				&:hover { color:$text !important; text-decoration:underline;}
			}
		}

		#wp-submit { font-size:14px; font-weight:normal; padding:5px 20px; color:#fff; text-decoration:none; -webkit-border-radius:3px; -moz-border-radius:3px; border-radius:3px; background:$text; border:none; cursor:pointer; font-family:Arial, Helvetica, sans-serif; line-height:16px;}
	}
');
?>