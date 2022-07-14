<?php
/*
	Default page template
*/

get_header(); 

global $post;
?>

    <div class="showcase inner">
        <div class="box">
            <h1>Search results</h1>
        </div><!-- box -->
    </div><!-- showcase -->

    <div class="container">
    	<div class="box">
            <div class="content">
                <div class="content-left">
                    <?php if(have_posts()): ?>
                        <ul class="search-results">
                            <?php while(have_posts()) : the_post(); ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_title(); ?>
                                        <span><?php echo get_the_permalink(); ?></span>
                                    </a>
                                </li>
                            <?php endwhile; wp_reset_query(); ?>
                        </ul>

                    <?php else: ?>
                        <p>We couldn't find any matches for &quot;<?php echo $s; ?>&quot;.</p>
                    <?php endif; ?>
                </div><!-- conten-left -->

                <div class="sidebar">
                    <div class="featured clearfix">
                        <ul>
                            <?php 
                                while(has_sub_field('home_boxes', 2)):
                                $attachment_id = get_sub_field('home_box_image');
                                $box_image = vt_resize($attachment_id,'' , 300, 135, true);
                            ?>
                                <li>
                                    <img src="<?php echo $box_image[url]; ?>" alt="<?php the_sub_field('home_box_heading'); ?>" />
                                    <h3><a href="<?php the_sub_field('home_box_heading'); ?>" title="<?php the_sub_field('home_box_heading'); ?>"><?php the_sub_field('home_box_heading'); ?></a></h3>
                                    <p><?php the_sub_field('home_box_content'); ?></p>
                                    <a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_button_label'); ?>" class="read-more"><?php the_sub_field('home_box_button_label'); ?></a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div><!-- featured -->
                </div><!-- sidebar -->

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>