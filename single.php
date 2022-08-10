<?php
/*
	Default single post template
*/

get_header(); 

global $post;
?>

    <div class="showcase inner">
        <div class="box">
            <h1>
            	<?php echo get_the_title($post->ID); ?>
            	<span><?php the_time("j M Y"); ?></span>
            </h1>
        </div><!-- box -->
    </div><!-- showcase -->

    <div class="container">
    	<div class="box">
            <div class="content">
                <div class="content-left">
                    <?php 
                        if(has_post_thumbnail()):
                        $attachment_id = get_post_thumbnail_id($post->ID);
                        $banner_image = vt_resize( $attachment_id,'' , 580, 300, true ); // Set to false if you don't want to crop the image
                    ?>
                       <div class="single-img"><img src="<?php echo $banner_image['url']; ?>" alt="<?php the_sub_field('home_banner_caption_heading'); ?>" /></div>
                    <?php endif; ?>

                    <?php while(have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; wp_reset_query(); ?>
                    
                    <?php //comments_template(); ?>
                </div><!-- conten-left -->

                <div class="sidebar">
                    <?php get_sidebar('Blog'); ?>
                </div>
                <!-- sidebar -->

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>