<?php
/*
	Template name: Contact
*/

get_header(); 

global $post;

$address = get_field('contact_address');
?>
    <?php include('inner-banner.php'); ?>

    <div class="container contact">
    	<div class="box">
            <div class="content">
                <div class="content-left">
                    <?php while(have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; wp_reset_query(); ?>
                </div><!-- conten-left -->

                <div class="sidebar">
                    <div class="widget">
                        <h3>Address</h3>
                        <p><?php echo str_replace(", ", "<br />", $address['address']); ?></p>
                    </div><!-- widget -->

                    <?php if(get_field('contact_phone')): ?>
                        <div class="widget">
                            <h3>Phone</h3>
                            <p><?php the_field('contact_branch'); ?><br><?php the_field('contact_phone'); ?></p>
                            <p><?php the_field('contact_branch2'); ?><br><?php the_field('contact_phone2'); ?></p>
                            <p><?php the_field('contact_branch3'); ?><br><?php the_field('contact_mobile3'); ?></p>
                        </div><!-- widget -->
                    <?php endif; ?>

                    <?php if(get_field('contact_email')): ?>
                        <div class="widget">
                            <h3>Email</h3>
                            <p><?php echo hide_email(get_field('contact_email')); ?></p>
                        </div><!-- widget -->
                    <?php endif; ?>
                </div><!-- sidebar -->

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>