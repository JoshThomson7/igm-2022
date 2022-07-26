<?php
/*
	Default page template
*/

get_header(); 

global $post;
$post_id = $post->ID;

if(get_field('page_fullwidth')) {
    $layout = 'fullwidth';
} else {
    $layout = 'content-left';
}
?>
    <?php include('inner-banner.php'); ?>

    <div class="container">
    	<div class="max__width">
            <div class="content">
                <div class="<?php echo $layout; ?>">
                    <?php while(have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; wp_reset_query(); ?>

                    <?php flexible_content(); ?>
                </div><!-- conten-left -->

                <?php
                    // Sidebar
                    if(!get_field('page_fullwidth')) {
                        include('sidebar-page.php');
                    }
                ?>

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>