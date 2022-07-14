<?php
/*
	Wordpress Security Functions
	Author: FL1 Group - www.fl1group.com
	
	Version: 1.0 (Last update: 29 Aug 2013)
	-------------------------------------------------------------------------
		0. CUSTOM LOGIN ERROR
		1. REMOVE UNNECESSARY BITS FROM HEADER OUTPUT
		2. COMMENTS SECURITY
		3. AUTO LOG OUT
		4. ROOT RELATIVE URLs
		5. AUTHOR URLS
*/

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                             0. CUSTOM LOGIN ERRORT                                             */
/*                                                                                                                */             
/* ===============================================================================================================*/
/* 
	Change the Wordpress login error messages so they don't give the hint that the password
	for a given existing username exists.
*/
add_filter( 'login_errors', 'fob_login_errors' );
function fob_login_errors( $message ) {
  global $errors;
  if ( isset( $errors->errors['invalid_username'] ) || isset( $errors->errors['incorrect_password'] ) ) {
    $message = sprintf( '<strong>ERROR</strong>: Invalid <strong>username</strong> and/or <strong>password</strong>.<br><a href="%1$s" title="%2$s">%3$s</a>?'
                      , site_url( 'wp-login.php?action=lostpassword', 'login' )
                      , 'Request a new password'
                      , 'Lost Password'
                      );
  }
  return $message;
}

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                1. REMOVE UNNECESSARY BITS FROM HEADER OUTPUT                                    */
/*                                                                                                                */             
/* ===============================================================================================================*/
// This information may prove a goldmine for WordPress hackers as 
// they can easily target blogs that are using the older and less secure 
// versions of WordPress software
// Source: http://benword.com/how-to-hide-that-youre-using-wordpress/

function roots_head_cleanup() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);  

	global $wp_widget_factory;
  	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

  	add_filter('use_default_gallery_style', '__return_null');
}
add_action('init', 'roots_head_cleanup');


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                              2. COMMENTS SECURITY                                              */
/*                                                                                                                */             
/* ===============================================================================================================*/
// The comment box in WordPress is like a basic HTML editor and
// people can use HTML tags like <b>, <a>, <i>, etc to highlight 
// certain words in their comment or add live links. For more
// security, we remove this functionality.

add_filter( 'pre_comment_content', 'wp_specialchars' );


// Removes comment classes that show user name
function remove_comment_author_class( $classes ) {
	foreach( $classes as $key => $class ) {
		if(strstr($class, "comment-author-")) {
			unset( $classes[$key] );
		}
	}
	return $classes;
}
add_filter( 'comment_class' , 'remove_comment_author_class' );


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                               3. AUTO LOG OUT                                                  */
/*                                                                                                                */             
/* ===============================================================================================================*/
// Source: http://wpmu.org/how-to-extend-the-auto-logout-period-in-wordpress/
add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_3_hours' );

function keep_me_logged_in_for_3_hours($expirein) {
    return 10800; // 3 hours in seconds
}


/* ===============================================================================================================*/
/*                                                                                                                */
/*                                             4. ROOT RELATIVE URLs                                              */
/*                                                                                                                */             
/* ===============================================================================================================*/
/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function roots_root_relative_url($input) {
  $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
      '$matches',
      // If full URL is home_url("/"), return a slash for relative root
      'if (isset($matches[0]) && $matches[0] === home_url("/")) { return "/";' .
      // If domain is equal to home_url("/"), then make URL relative
      '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
      // If domain is not equal to home_url("/"), do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );

  return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function roots_fix_duplicate_subfolder_urls($input) {
  $output = roots_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }

  return $output;
}

if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
  add_filter('bloginfo_url', 'roots_root_relative_url');
  add_filter('theme_root_uri', 'roots_root_relative_url');
  add_filter('stylesheet_directory_uri', 'roots_root_relative_url');
  add_filter('template_directory_uri', 'roots_root_relative_url');
  add_filter('script_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'roots_root_relative_url');
  add_filter('the_permalink', 'roots_root_relative_url');
  add_filter('wp_list_pages', 'roots_root_relative_url');
  add_filter('wp_list_categories', 'roots_root_relative_url');
  add_filter('wp_nav_menu', 'roots_root_relative_url');
  add_filter('the_content_more_link', 'roots_root_relative_url');
  add_filter('the_tags', 'roots_root_relative_url');
  add_filter('get_pagenum_link', 'roots_root_relative_url');
  add_filter('get_comment_link', 'roots_root_relative_url');
  add_filter('month_link', 'roots_root_relative_url');
  add_filter('day_link', 'roots_root_relative_url');
  add_filter('year_link', 'roots_root_relative_url');
  add_filter('tag_link', 'roots_root_relative_url');
  add_filter('the_author_posts_link', 'roots_root_relative_url');
}

/* ===============================================================================================================*/
/*                                                                                                                */
/*                                               5. AUTHOR URLs                                                   */
/*                                                                                                                */             
/* ===============================================================================================================*/
/*
	Change the author URL slug so it doesn't show the actual username but the nickname
	Source: http://wordpress.stackexchange.com/questions/5742/change-the-author-slug-from-username-to-nickname
*/
add_filter( 'request', 'wpse5742_request' );
function wpse5742_request( $query_vars )
{
    if ( array_key_exists( 'author_name', $query_vars ) ) {
        global $wpdb;
        $author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='nickname' AND meta_value = %s", $query_vars['author_name'] ) );
        if ( $author_id ) {
            $query_vars['author'] = $author_id;
            unset( $query_vars['author_name'] );    
        }
    }
    return $query_vars;
}

add_filter( 'author_link', 'wpse5742_author_link', 10, 3 );
function wpse5742_author_link( $link, $author_id, $author_nicename )
{
    $author_nickname = get_user_meta( $author_id, 'nickname', true );
    if ( $author_nickname ) {
        $link = str_replace( $author_nicename, $author_nickname, $link );
    }
    return $link;
}

add_action( 'user_profile_update_errors', 'wpse5742_set_user_nicename_to_nickname', 10, 3 );
function wpse5742_set_user_nicename_to_nickname( &$errors, $update, &$user )
{
    if ( ! empty( $user->nickname ) ) {
        $user->user_nicename = sanitize_title( $user->nickname, $user->display_name );
    }
}
?>