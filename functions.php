<?php
/*
	MAIN FUNCTIONS	
	Version: 3.6 (Last update: 8 Oct 2013)
	-------------------------------------------------------------------------
		0.  Custom Functions
		1. 	WP Image Resize
		2. 	Custom Post Types and Taxonomies
		3. 	Advanced Custom Fields (register options page, register fields)
		4. 	Sidebars
		5. 	Widgets
		6. 	Featured Images
		7. 	Custom Excerpts
		8. 	Breadcrumbs (with Custom Post Type and Taxonomy Support)
		9. 	Fancybox (automatically add Fancybox to images in the_content())
		10. Pagination
		11. Custom Login Page
		12. Superfish Menu
		13. Security
		14. Dashboard
		15. Custom Columns
		16. Mobile Detect
		17. Menu Walkers
*/


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                             0. CUSTOM FUNCTIONS                                                */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Encrypt email address
function hide_email($email) { 
	$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz'; 
	$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999); 
	for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])]; 
	$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";'; 
	$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));'; 
	$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"'; 
	$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
	$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>'; return '<span id="'.$id.'">[javascript protected email address]</span>'.$script; 
}

// INCLUDE FLEX CONTENT
include('modules/flexible-content/functions/fc-functions.php');

// Get top parent ID
function get_top_parent_page_id() {
    global $post;
    // Check if page is a child page (any level)
    if ($post->ancestors) {
        //  Grab the ID of top-level page from the tree
        return end($post->ancestors);
    } else {
        // Page is the top level, so use  it's own id
        return $post->ID;
    }
}


/**
 * Wordpress has a known bug with the posts_per_page value and overriding it using
 * query_posts. The result is that although the number of allowed posts_per_page
 * is abided by on the first page, subsequent pages give a 404 error and act as if
 * there are no more custom post type posts to show and thus gives a 404 error.
 *
 * This fix is a nicer alternative to setting the blog pages show at most value in the
 * WP Admin reading options screen to a low value like 1.
 *
 */
function custom_posts_per_page( $query ) {
 
    if ( $query->is_search() ) {
        set_query_var('posts_per_page', 10);
    }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );


// Taxonomy archive pagination
/*add_filter( 'option_posts_per_page', 'resource_type_ppp' );
function resource_type_ppp( $value ) {
    return (is_tax('resource_type')) ? 10 : $value;
}*/


/*
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category

if ( ! function_exists( 'post_is_in_descendant_term' ) ) {
	function post_is_in_descendant_term( $terms, $_post = null ) {
		foreach ( (array) $terms as $term ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $terms, 'resource_type' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
} */


// Convert bytes to a humena readable format
/*function ByteSize($bytes) {
    $size = $bytes / 1024;
    if($size < 1024)
        {
        $size = number_format($size, 2);
        $size .= ' KB';
        } 
    else 
        {
        if($size / 1024 < 1024) 
            {
            $size = number_format($size / 1024, 2);
            $size .= ' MB';
            } 
        else if ($size / 1024 / 1024 < 1024)  
            {
            $size = number_format($size / 1024 / 1024, 2);
            $size .= ' GB';
            } 
        }
    return $size;
} */


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                              1. WP IMAGE RESIZE                                                */
/*                                                                                                                */             
/* ===============================================================================================================*/

include("modules/wp-img-resize.php");

		/* USAGE:
		-------------------------------------------------------------------------------------
		
				Featured Image
				-----------------------------------------------------------------------------
				<?php
					$attachment_id = get_post_thumbnail_id( $post->ID ); 
					$banner_image = vt_resize( $attachment_id,'' , 98, 98, true ); // Set to false if you don't want to crop the image 
				?>
				
				
				Custom Fields
				-----------------------------------------------------------------------------
				<?php 
					$attachment_id = get_sub_field('home_banners_image');
					$banner_image = vt_resize( $attachment_id,'' , 1169, 365, true ); // Set to false if you don't want to crop the image
				?>
				
				-----------------------------------------------------------------------------
				
				And then just use this here you want the image to be displayed:
				
				<?php echo $banner_image[url]; ?>
				<?php echo $banner_image[width]; ?> // Optional
				<?php echo $banner_image[height]; ?> // Optional
		*/
		

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                     2. CUSTOM POST TYPES AND TAXONOMIES                                        */
/*                                                                                                                */             
/* ===============================================================================================================*/
// DOCUMENTATION:
// --------------------------------------------------------------------------------
// Post Types: http://codex.wordpress.org/Function_Reference/register_post_type
// Taxonomies: http://codex.wordpress.org/Function_Reference/register_taxonomy

//include("modules/custom-post-types-taxonomies.php");


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                          3. ADVANCED CUSTOM FIELDS                                             */
/*                                                                                                                */             
/* ===============================================================================================================*/

// REGISTER OPTIONS PAGES
// Docs: http://www.advancedcustomfields.com/docs/tutorials/register-multiple-options-pages/

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Global Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Admin Options',
		'parent_slug'	=> 'theme-general-settings',
	));
}


// REGISTER FIELDS
// Get new fields from: http://www.advancedcustomfields.com/add-ons/

/*if(function_exists('register_field')) 
{
	// REGISTER CATEGORIES FIELD
	register_field('Categories_field', dirname(__File__) . '/modules/categories.php');
}*/


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                                4. SIDEBARS                                                     */
/*                                                                                                                */             
/* ===============================================================================================================*/ 
if ( function_exists('register_sidebar') ) {
	// Default Sidebar
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
	));
}


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                               5. WIDGETS                                                       */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Add the Twitter Widget
// include('widgets/widget-twitter.php');
 

/*================================================================================================================*/
/*                                                                                                                */
/*                                           6. FEATURED IMAGES                                                   */
/*                                                                                                                */             
/*================================================================================================================*/
add_theme_support( 'post-thumbnails' ); // Enable Featured Images 

/*if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'home-slideshow-image', 640, 319, true );
}*/


/*================================================================================================================*/
/*                                                                                                                */
/*                                           7. CUSTOM EXCERPTS                                                   */
/*                                                                                                                */             
/*================================================================================================================*/
// Wordpress custom excerpt length
/*function custom_excerpt_length($length) {
	return 10;
}
add_filter('excerpt_length', 'custom_excerpt_length');
*/


// Custom length by word
function trunc($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit) {
	array_pop($words);
	//add a ... at last article when more than limit word count
	return $alex = implode(' ', $words)."[...]"; } else {
	//otherwise
	return $alex = implode(' ', $words); }
}


/*================================================================================================================*/
/*                                                                                                                */
/*                                              8. BREADCRUMBS                                                    */
/*                                                                                                                */             
/*================================================================================================================*/
/*
	Usage: Add <?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?> wherever you want the breadcrumbs to be displayed
*/

function dimox_breadcrumbs() {
	
	/*
	/	If using Custom Post Types with Taxonomies, we need 
		to run through the array of terms first so we can display them later
	
	if ( get_post_type() == 'project' ) { // Projects
		// Get terms for taxonomy project_cat
		$terms = get_the_terms($post->id, 'project_cat');
		//print_r($terms);
		$counterios='0';
		$project_cat_id='';
		foreach($terms as $array){    
			foreach($array as $key=>$value){
				if($counterios=='0'){
					$project_cat_id =$value;
				}else{ }
				$counterios++;
			}
		}
	}*/
	
  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = '<span class="separator"></span>'; // delimiter between crumbs
  $home = 'Home'; // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  global $post;
  $homeLink = get_bloginfo('url');
 
  if (is_home() || is_front_page()) {
 
    if ($showOnHome == 1) echo '<div class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
 
  } else {
 
    echo '<div class="breadcrumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;    
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb;
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
	
	/*------------------------------------------------------------------------*/
	/*                 FL1 Additions - Custom Post Types                      */
	/*------------------------------------------------------------------------*/
	} elseif ( is_single() ) {
      if ( get_post_type() == 'project' ) { // Projects
        $post_type = get_post_type_object(get_post_type());
        $slug = str_replace("%project_cat%", "", $post_type->rewrite);
		
		global $post;
		
		//echo '<a href="' . $homeLink . '/portfolio" title="Portfolio">Portfolio</a> ' . $delimiter . ' ';
		echo '<a href="' . $homeLink . '/' . $slug['slug'] . '" title="' . $post_type->labels->singular_name . '">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
		// echo '<a href="' . $homeLink . '/' . $slug['slug'] . $terms[$letter_id]->slug . '/" title="View all listings under the letter ' . $terms[$letter_id]->name . '">' . $terms[$letter_id]->name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
	
	  } else { // Normal posts
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
	
	} elseif ( is_tax() ) {
		$post_type = get_post_type_object(get_post_type());
        $slug = str_replace("%project_cat%", "", $post_type->rewrite);
		
		global $wp_query;
		$term_id =	$wp_query->get_queried_object_id();
		$term = get_term_by('id', $term_id , 'project_cat');
		
		echo '<a href="' . $homeLink . '/portfolio" title="Portfolio">Portfolio</a> ' . $delimiter . ' ';
        echo $before . $term->name . $after;
	}
 	/*-----------------------------------------------*/

 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page() || is_tax() ) echo ' <span class="breadcrumb-pagecount">(';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page() || is_tax() ) echo ')</span>';
    }
 
    echo '</div>';
 
  }
} // end dimox_breadcrumbs()


/*================================================================================================================*/
/*                                                                                                                */
/*                                               9. FANCYBOX                                                      */
/*                                                                                                                */             
/*================================================================================================================*/
/*
	Automatically adds the fancybox class to the link of any image uploaded inside the_content().
	All the fancybox files are located inside scripts/fancybox/.
*/

add_filter('the_content', 'add_fancybox_class_replace');
function add_fancybox_class_replace ($content)
{	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1href=$2$3.$4$5 class="fancybox"$6>';
    $content = preg_replace($pattern, $replacement, $content);
	$content = str_replace("%LIGHTID%", $post->ID, $content);
    return $content;
}


/*================================================================================================================*/
/*                                                                                                                */
/*                                               10. PAGINATION                                                   */
/*                                                                                                                */             
/*================================================================================================================*/
/*
	Usage: <?php pagination (); ?>
	More info: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
	
	STYLE - Paste the code below on your stylesheet, if used, and change accordingly
	------------------------------------------------------------------------------------
	.pagination { clear:both; padding:5px 0; position:relative; font-size:11px; line-height:13px; overflow:hidden; border-bottom:1px #c9c9c9 dotted; margin:0 30px 20px 0;}
	.page-count { float:left; padding:5px 0;}
	.page-numbers { float:right;}
	.pagination span, .pagination a { display:block; float:left; margin: 0; padding:4px 7px 3px; text-decoration:none; width:auto; color:#404040;}
	.pagination a:hover { background: #404040; color:#fff;}
	.pagination .current { padding:4px 7px 3px; background: #62a809; color:#fff;}

*/

function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><div class=\"page-count\">Page ".$paged." of ".$pages."</div><div class=\"page-numbers\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div></div>\n";
     }
}

/*================================================================================================================*/
/*                                                                                                                */
/*                                            11. CUSTOM LOGIN PAGE                                               */
/*                                                                                                                */             
/*================================================================================================================*/ 
/*
	login.css is located in the /css/ folder of the theme

*/
// Style
function add_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/login.css" />';
}
add_action('login_head', 'add_custom_login');

// Change Wordpress logo URL to the website's Home Page
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return get_bloginfo('url');
}


/*================================================================================================================*/
/*                                                                                                                */
/*                                            12. SUPERFISH MENU                                                  */
/*                                                                                                                */             
/*================================================================================================================*/ 
add_action( 'wp_enqueue_scripts', 'superfish_libs' );  
function superfish_libs()  
{  
    // Register each script, setting appropriate dependencies  
    wp_register_script('hoverintent', get_template_directory_uri() . '/scripts/superfish/js/hoverIntent.js');  
    wp_register_script('bgiframe',    get_template_directory_uri() . '/scripts/superfish/js/jquery.bgiframe.min.js');  
    wp_register_script('superfish',   get_template_directory_uri() . '/scripts/superfish/js/superfish.js', array( 'jquery', 'hoverintent', 'bgiframe' ));  
    wp_register_script('supersubs',   get_template_directory_uri() . '/scripts/superfish/js/supersubs.js', array( 'superfish' ));  
  
    // Enqueue supersubs, we don't need to enqueue any others in this case, as the dependencies take care of it for us  
    wp_enqueue_script('supersubs'); 
 
    // Register each style, setting appropriate dependencies 
    // wp_register_style('superfishbase',   get_template_directory_uri() . '/superfish/css/superfish.css'); 
    // wp_register_style('superfishvert',   get_template_directory_uri() . '/superfish/css/superfish-vertical.css', array( 'superfishbase' )); 
    // wp_register_style('superfishnavbar', get_template_directory_uri() . '/superfish/css/superfish-navbar.css', array( 'superfishvert' )); 
 
    // Enqueue superfishnavbar, we don't need to enqueue any others in this case either, as the dependencies take care of it  
    wp_enqueue_style('superfishnavbar');  
}


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                                 13. SECURITY                                                   */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Include security functions
include("modules/security.php");


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                                14. DASHBOARD                                                   */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Include dashboard functions
include("modules/dashboard.php");


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                              15. CUSTOM COLUMNS                                                */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Include custom columns functions
//include("modules/custom-columns.php");


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                              16. MOBILE DETECT                                                 */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Include Mobile Detect
/*include("modules/mobile_detect.php");
$detect = new Mobile_Detect();
*/

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                              17. MENU WALKERS                                                  */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Include Menu Walkers
include("modules/menu-walkers.php");
?>