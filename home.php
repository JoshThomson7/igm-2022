<?php
/*
	Template name: Home
*/

get_header(); ?>

    <div class="showcase">
    	<div id="home_banners" class="owl-carousel">
    		<?php 
                while(has_sub_field('home_banners')):
                $attachment_id = get_sub_field('home_banner_image');
                $banner_image = vt_resize( $attachment_id,'' , 1057, 411, true ); // Set to false if you don't want to crop the image
            ?>
                <div class="slide" style="background-image:url(<?php echo $banner_image[url]; ?>);">
			        <div class="box">
			            <div class="caption">
			            	<h3><?php the_sub_field('home_banner_caption_heading'); ?></h3>
			                <p><?php the_sub_field('home_banner_caption_content'); ?></p>
			                <a href="<?php the_sub_field('home_banner_button_link'); ?>" title="<?php the_sub_field('home_banner_button_label'); ?>" class="more-button"><?php the_sub_field('home_banner_button_label'); ?></a>
			            </div><!-- caption -->
			        </div><!-- box -->
			    </div><!-- slide -->
			<?php endwhile; ?>
	    </div><!-- #home_banners -->
    </div><!-- showcase -->

    <div class="container">
    	<div class="box">
            <div class="featured home clearfix">
            	<ul>
            		<?php 
		                while(has_sub_field('home_boxes')):
		                $attachment_id = get_sub_field('home_box_image');
		                $box_image = vt_resize($attachment_id,'' , 300, 150, true);
		            ?>
	                	<li>
	                    	<a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_heading'); ?>"><img src="<?php echo $box_image[url]; ?>" alt="<?php the_sub_field('home_box_heading'); ?>" /></a>
	                    	<h3><a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_heading'); ?>"><?php the_sub_field('home_box_heading'); ?></a></h3>
	                        <?php if(get_sub_field('home_box_content')): ?><p><?php the_sub_field('home_box_content'); ?></p><?php endif; ?>
	                        
	                        <?php /*if(get_sub_field('home_box_button_link')): ?>
	                        	<a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_button_label'); ?>" class="read-more"><?php the_sub_field('home_box_button_label'); ?></a>
	                        <?php endif; */?>
	                    </li>
	                <?php endwhile; ?>
                </ul>
            </div><!-- featured -->
        </div><!-- box -->

<?php get_footer(); ?>