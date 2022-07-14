    <?php 
        if(has_post_thumbnail()) {
            $attachment_id = get_post_thumbnail_id($post->ID);
            $banner_image = vt_resize( $attachment_id,'' , 1057, 150, true ); // Set to false if you don't want to crop the image
        }
    ?>

    <div class="showcase inner" style="background-image:url(<?php echo $banner_image['url']; ?>);">
        <div class="box">

            <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
            <?php if (is_category()) { ?>
                <h1><?php printf(__('%s', 'kubrick'), single_cat_title('', false)); ?></h1>
            <?php } elseif( is_tag() ) { ?>
                <h1><?php printf(__('Posts Tagged &#8216;%s&#8217;', 'kubrick'), single_tag_title('', false) ); ?></h1>
            <?php } elseif (is_month()) { ?>
                <h1><?php printf(_c('Archive for %s|Monthly archive page', 'kubrick'), get_the_time(__('F, Y', 'kubrick'))); ?></h1>
            <?php } else { ?>
                <h1><?php echo get_the_title($post->ID); ?></h1>
            <?php } ?>
        </div><!-- box -->
    </div><!-- showcase -->