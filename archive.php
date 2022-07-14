<?php
/*
	Archive template
*/

get_header(); 

global $post;
?>

    <?php include('inner-banner.php'); ?>

    <div class="container">
    	<div class="box">
            <div class="content">
                <div class="content-left">     
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="article blog-cat">
                            
                            <div class="imgb">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <span class="blog-date">
                                        <span class="blog-month"><?php the_time("M"); ?></span>
                                        <span class="blog-day"><?php the_time("d"); ?></span>
                                    </span>
                                    
                                    <?php
                                        if(has_post_thumbnail()):
                                        $attachment_id = get_post_thumbnail_id( $post->ID ); 
                                        $article_img = vt_resize( $attachment_id,'' , 200, 200, true ); // Set to false if you don't want to crop the image 
                                    ?>
                                        <img src="<?php echo $article_img['url']; ?>" alt="<?php the_title(); ?>" />
                                    <?php else: ?>
                                        <img src="<?php bloginfo('stylesheet_directory'); ?>/img/news-holder.jpg" alt="<?php the_title(); ?>" />
                                    <?php endif; ?>
                                </a>
                            </div>

                            <div class="txtb">
                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                <?php the_excerpt(); ?>

                                <?php
                                    // Get the post tags,
                                    // limit to 4 and strip last comma
                                    $posttags = get_the_tags();
                                    $tag_counter = 0; $sep='';
                                    if($posttags):
                                ?>
                                    <span class="date finding">
                                        <?php // Set counter to 1 to limit the count
                                            foreach((array)$posttags as $tag) {
                                                $tag_counter++;
                                                echo '<a href="'. get_bloginfo('url') .'/tag/'. $tag->slug .'" title="Click here to view all articles tagged as'. $tag->name.'">'. $tag->name .'</a>, ';
                                                $sep = ', ';
                                                if( $tag_counter > 4 ) break;
                                            }
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div><!-- txtb -->
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="readmore">Read more</a>
                            <div class="clear"></div>
                        </div><!-- article -->
                    <?php endwhile; wp_reset_query(); ?>

                    <?php pagination(); ?>
                </div><!-- conten-left -->

                <div class="sidebar">
                    <?php get_sidebar('Blog'); ?>
                </div><!-- sidebar -->

                <div class="clear"></div>
            </div><!-- content -->
        </div><!-- box -->

<?php get_footer(); ?>