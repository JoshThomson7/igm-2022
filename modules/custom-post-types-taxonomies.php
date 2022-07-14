<?php
/*
	CUSTOM POST TYPES AND TAXONOMIES
	Author: FL1 Group - www.fl1group.com
	Version: 2.0
		
	// DOCUMENTATION:
	// --------------------------------------------------------------------------------
	// Post Types: http://codex.wordpress.org/Function_Reference/register_post_type
	// Taxonomies: http://codex.wordpress.org/Function_Reference/register_taxonomy

	INDEX:

		1. POST TYPES
		2. TAXONOMIES
		3. URL REWRITING

	
	CPT Dashboard Menu Position
		5 - below Posts
		10 - below Media
		15 - below Links
		20 - below Pages
		25 - below comments
		60 - below first separator
		65 - below Plugins
		70 - below Users
		75 - below Tools
		80 - below Settings
		100 - below second separator
*/

/*================================================================================================================*/
/*                                                                                                                */
/*                                                1. POST TYPES                                                   */
/*                                                                                                                */             
/*================================================================================================================*/
/*--------------------------------------------------------------------------*/
/*                               DISTRIBUTOR                                */   
/*--------------------------------------------------------------------------*/
add_action( 'init', 'create_distributor_posttype', 4 );
function create_distributor_posttype() 
{
  	$labels = array(
		'name' => __( 'Distributor' ),
		'singular_name' => __( 'Distributor' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create Distributor' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Distributor' ),
		'new_item' => __( 'New Distributor' ),
		'view' => __( 'View Distributor' ),
		'view_item' => __( 'View Distributor' ),
		'search_items' => __( 'Search Distributors' ),
		'not_found' => __( 'No distributors found' ),
		'not_found_in_trash' => __( 'No distributors found in trash' ),
		'parent' => __( 'Parent Distributor' ),
	  ); 
	
	$args = array(
		'labels' => $labels,				  	
		'description' => __( 'This is where you can create distributors.' ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'menu_icon' => 'dashicons-archive',
		'menu_position' => 21,
		'hierarchical' => true,
		'_builtin' => false, // It's a custom post type, not built in!
		'rewrite' => array( 'slug' => 'distributor/%continent%', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies' => array('continent'),
	  ); 
	
	register_post_type('distributor', $args);
}


/*--------------------------------------------------------------------------*/
/*                                 PRINTER                                  */   
/*--------------------------------------------------------------------------*/
add_action( 'init', 'create_printers_posttype', 4 );
function create_printers_posttype() 
{
  	$labels = array(
		'name' => __( 'Printer' ),
		'singular_name' => __( 'Printer' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Create Printer' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Printer' ),
		'new_item' => __( 'New Printer' ),
		'view' => __( 'View Printer' ),
		'view_item' => __( 'View Printer' ),
		'search_items' => __( 'Search Printers' ),
		'not_found' => __( 'No printers found' ),
		'not_found_in_trash' => __( 'No printers found in trash' ),
		'parent' => __( 'Parent Printer' ),
	  ); 
	
	$args = array(
		'labels' => $labels,				  	
		'description' => __( 'This is where you can create printers.' ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'menu_icon' => 'dashicons-art',
		'menu_position' => 22,
		'hierarchical' => true,
		'_builtin' => false, // It's a custom post type, not built in!
		'rewrite' => array( 'slug' => 'printer/%country%', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies' => array('country'),
	  ); 
	
	register_post_type('printer', $args);
}

/*================================================================================================================*/
/*                                                                                                                */
/*                                                2. TAXONOMIES                                                   */
/*                                                                                                                */             
/*================================================================================================================*/
/*--------------------------------------------------------------------------*/
/*                             continent                                */     
/*--------------------------------------------------------------------------*/
/* ================ Create taxonomy "continent" ================ */

// Hook into the init action and call create_continent_taxonomies when it fires
add_action( 'init', 'create_continent_taxonomies', 0 );

function create_continent_taxonomies() 
{
  // Add new taxonomy, make it hierarchical => true for categories-like taxonomies)
  $labels = array(
    'name' => _x( 'Continents', 'taxonomy general name' ),
    'singular_name' => _x( 'Continent', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Continents' ),
    'all_items' => __( 'All Continents' ),
    'parent_item' => __( 'Parent Continents' ),
    'parent_item_colon' => __( 'Parent Continents:' ),
    'edit_item' => __( 'Edit Continent' ), 
    'update_item' => __( 'Update Continent' ),
    'add_new_item' => __( 'Add New Continent' ),
    'new_item_name' => __( 'New Continent' ),
    'menu_name' => __( 'Continents' ),
  );    

  register_taxonomy('continent',array('distributor'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'public' => true,
    'rewrite' => array( 'slug' => 'distributor', 'with_front' => true ),
  ));
}


/*--------------------------------------------------------------------------*/
/*                             country                                */     
/*--------------------------------------------------------------------------*/
/* ================ Create taxonomy "country" ================ */

// Hook into the init action and call create_country_taxonomies when it fires
add_action( 'init', 'create_country_taxonomies', 0 );

function create_country_taxonomies() 
{
  // Add new taxonomy, make it hierarchical => true for categories-like taxonomies)
  $labels = array(
    'name' => _x( 'Countries', 'taxonomy general name' ),
    'singular_name' => _x( 'Countries', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Countries' ),
    'all_items' => __( 'All Countries' ),
    'parent_item' => __( 'Parent Countries' ),
    'parent_item_colon' => __( 'Parent Countries:' ),
    'edit_item' => __( 'Edit Country' ), 
    'update_item' => __( 'Update Country' ),
    'add_new_item' => __( 'Add New Country' ),
    'new_item_name' => __( 'New Country' ),
    'menu_name' => __( 'Countries' ),
  );    

  register_taxonomy('country',array('printer'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'public' => true,
    'rewrite' => array( 'slug' => 'printer', 'with_front' => true ),
  ));
}


/*--------------------------------------------------------------------------*/
/*                            REWRITE RULES                                 */     
/*--------------------------------------------------------------------------*/
// Rewrite rule to display hierarchical URLs
// IMPORTANT: Every time you make a change to any rewrite rule in the code below, or above, 
// remember to visit the Permalinks page in Wordpress to flush the rules. No need to click
// on Update, simply visit it.

// Distributor
function filter_distributor_link($link, $post)
{
    if ($post->post_type != 'distributor')
        return $link;

    if ($cats = get_the_terms($post->ID, 'continent'))
        $link = str_replace('%continent%', array_pop($cats)->slug, $link);

    //if ($cats = get_the_terms($post->ID, 'country'))
        //$link = str_replace('%country%', array_pop($cats)->slug, $link);
    
    return $link;
}

add_filter('post_type_link', 'filter_distributor_link', 10, 2);


// Printer
function filter_printer_link($link, $post)
{
    if ($post->post_type != 'printer')
        return $link;

    if ($cats = get_the_terms($post->ID, 'country'))
        $link = str_replace('%country%', array_pop($cats)->slug, $link);

    //if ($cats = get_the_terms($post->ID, 'country'))
        //$link = str_replace('%country%', array_pop($cats)->slug, $link);
    
    return $link;
}

add_filter('post_type_link', 'filter_printer_link', 10, 2);
?>