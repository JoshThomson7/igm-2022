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
    	<div class="box">
            <div class="content">
                <div class="<?php echo $layout; ?>">
                    <?php while(have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; wp_reset_query(); ?>

                    <?php if(have_rows('flexible_content')): ?>
                        <div class="flexible-content-wrap">
                            <?php while(have_rows('flexible_content')) : the_row(); ?>
                                <div class="flexible-content">
                                    <?php // -------------------------------------- FREE TEXT -------------------------------------- //
                                        if(get_row_layout() == 'free_text'): ?>

                                        <?php echo apply_filters('the_content', get_sub_field('free_text')); ?>

                                    <?php // -------------------------------------- TABS -------------------------------------- //
                                        elseif(get_row_layout() == 'tabs'): ?>
                                        <ul class="tabs">
                                            <?php
                                                while(has_sub_field('tabs')):
                                                $get_tab_id = str_replace(" ", "_", strtolower(get_sub_field('tab_title')));
                                                $tab_id = ereg_replace("[^A-Za-z0-9]", "", $get_tab_id);
                                            ?>
                                                <li><a href="#<?php echo $tab_id; ?>" title="<?php the_sub_field('tab_title'); ?>"><?php the_sub_field('tab_title'); ?></a></li>
                                            <?php endwhile; ?>
                                        </ul>

                                        <?php
                                            while(has_sub_field('tabs')):
                                            $get_tab_id = str_replace(" ", "_", strtolower(get_sub_field('tab_title')));
                                            $tab_id = ereg_replace("[^A-Za-z0-9]", "", $get_tab_id);
                                        ?>
                                            <div id="<?php echo $tab_id; ?>" class="tab-content">
                                                <h3><?php the_sub_field('tab_title'); ?></h3>
                                                <?php echo apply_filters('the_content', get_sub_field('tab_content')); ?>

                                                <div class="clear"></div>
                                            </div><!-- tab-content -->
                                        <?php endwhile; ?>

                                    <?php // -------------------------------------- ACCORDION -------------------------------------- //
                                        elseif(get_row_layout() == 'accordion'): ?>

                                        <?php
                                            while(has_sub_field('accordion')):
                                            $tab_id = str_replace(" ", "_", strtolower(get_sub_field('accordion_title')));
                                        ?>
                                            <h3 class="toggle"><?php the_sub_field('accordion_title'); ?><span class="icon-plus"></span></h3>
                                            <div id="<?php echo $tab_id; ?>" class="accordion-content">
                                                <?php echo apply_filters('the_content', get_sub_field('accordion_content')); ?>

                                                <div class="clear"></div>
                                            </div><!-- tab-content -->
                                        <?php endwhile; ?>

                                    <?php // ----------------------------- Gallery -----------------------------//
                                        elseif(get_row_layout() == 'gallery'):
                                        
                                        $images = get_sub_field('gallery');
                                        if($images):
                                    ?>
                                            <ul class="lightGallery">
                                                <?php
                                                    foreach($images as $image):
                                                    $attachment_id = $image['ID'];
                                                    $gallery_img = vt_resize($attachment_id,'' , 300, 380, true);
                                                    $gallery_img_org = vt_resize($attachment_id,'' , 1200, 1200, false);
                                                ?>
                                                    <li data-src="<?php echo $gallery_img_org[url]; ?>">
                                                        <a href="#" title=""><img src="<?php echo $gallery_img[url]; ?>" /></a>
                                                    </li>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div><!-- flexible-content -->
                            <?php endwhile; ?>
                        </div><!-- flexible-content-wrap -->
                    <?php endif; ?>
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