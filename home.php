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
			<div class="slide" style="background: linear-gradient(to bottom, rgba(0,0,0, 0.5), rgba(0,0,0, 0.5)),url(<?php echo $banner_image['url']; ?>) no-repeat; background-size: cover;">
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

<?php flexible_content(); ?>

<?php get_footer(); ?>