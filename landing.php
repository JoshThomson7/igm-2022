<?php
/*
	Template name: Landing Page
*/

get_header(); 

global $post;

$post_id = $post->ID;
$parent_id = get_top_parent_page_id($post->ID); // Get top parent page ID width get_top_parent_page_id() in functions.php
$parent_page_objects = get_post($parent_id); // Store parent page objects
$parent_page_title = $parent_page_objects->post_title; // Get parent page title

$has_children = get_pages('child_of='.$post_id); // Get children pages
?>

    <div class="showcase inner">
		<?php 
            if(has_post_thumbnail()):
            $attachment_id = get_post_thumbnail_id($post->ID);
            $banner_image = vt_resize( $attachment_id,'' , 1057, 150, true ); // Set to false if you don't want to crop the image
        ?>
	   	   <img src="<?php echo $banner_image['url']; ?>" alt="<?php the_sub_field('home_banner_caption_heading'); ?>" />
        <?php endif; ?>

        <div class="box">
            <h1><?php echo get_the_title($post->ID); ?></h1>
        </div><!-- box -->
    </div><!-- showcase -->

    <div class="container">
    	<div class="box">
            <div class="content">
                <div class="content-left">
                    <?php while(have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; wp_reset_query(); ?>
                </div><!-- conten-left -->

                <div class="sidebar">
                    <?php
                        if(get_field('show_map')):
                        $map = get_field('location');
                    ?>  
                        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>  
                        <script type="text/javascript">
                            // When the window has finished loading create our google map below
                            google.maps.event.addDomListener(window, 'load', init);
                        
                            function init() {
                                // Define the latitude and longitude positions
                                var latitude = parseFloat("<?php echo $map[lat]; ?>");
                                var longitude = parseFloat("<?php echo $map[lng]; ?>");
                                var latlngPos = new google.maps.LatLng(latitude, longitude);

                                var mapOptions = {
                                    zoom: 12,
                                    center: latlngPos,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP,

                                    zoomControl: true,
                                    zoomControlOptions: {
                                        style: google.maps.ZoomControlStyle.SMALL,
                                        position: google.maps.ControlPosition.LEFT_BOTTOM
                                    },
                                    panControl: false,
                                    panControlOptions: {
                                        position: google.maps.ControlPosition.BOTTOM_RIGHT
                                    },

                                    mapTypeControl: true,
                                    mapTypeControlOptions: {
                                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                                        position: google.maps.ControlPosition.BOTTOM_CENTER
                                    },

                                    streetViewControl: true,
                                    streetViewControlOptions: {
                                        position: google.maps.ControlPosition.LEFT_BOTTOM
                                    },
                                    scrollwheel: false,
                                    draggable: true
                                };

                                // Define the map
                                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                                // Add the marker
                                var marker = new google.maps.Marker({
                                    position: latlngPos,
                                    map: map
                                });

                                // Center map on resize (responsive)
                                google.maps.event.addDomListener(window, "resize", function() {
                                    var center = map.getCenter();
                                    google.maps.event.trigger(map, "resize");
                                    map.setCenter(center); 
                                });                                
                            }
                        </script>
                        <div class="featured clearfix">
                            <div id="map"></div>
                        </div><!-- featured -->
                    <?php endif; ?>

                    <div class="featured clearfix">
                        <h3>Get in touch today</h3>
                        <?php echo do_shortcode('[contact-form-7 id="182" title="Landing Page"]'); ?>
                    </div><!-- featured -->
                </div><!-- sidebar -->

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>