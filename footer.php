        <?php if(get_field('cta_show', 'options')): ?>
            <div class="blue-box">
                <div class="box">
                    <div class="video">
                        <h3><?php the_field('cat_main_heading', 'options') ?></h3>
                        <a href="http://www.youtube.com/watch?v=<?php the_field('cta_video_id', 'options') ?>" class="fancybox">
                            <span class="icon icon-control-play"></span>
                            <div class="overlay"></div>
                            <img src="http://img.youtube.com/vi/<?php the_field('cta_video_id', 'options') ?>/0.jpg" alt="<?php the_title(); ?>" />
                        </a>    
                    </div><!-- video -->

                    <div class="news">
                        <h3><a href="<?php bloginfo('url'); ?>/blog/">News &amp; Case Studies</a></h3>

                        <?php // News query
                            $blog_query = new WP_Query ("post_tyepe=post&posts_per_page=2&order_by=date");
                            
                            while ($blog_query->have_posts()) : $blog_query->the_post();
                            $attachment_id = get_post_thumbnail_id($post->ID);
                            $news_img = vt_resize($attachment_id,'' , 400, 400, true);
                        ?>
                            <div class="news-item">
                                <div class="news-img">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $news_img[url]; ?>" alt="<?php the_title(); ?>" /></a>
                                </div><!-- news-img -->

                                <div class="news-content">
                                    <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo trunc(get_the_excerpt(), 16); ?></p>
                                    <span><?php the_time("j M Y"); ?></span>
                                </div><!-- news-content -->
                            </div><!-- news-item -->
                        <?php endwhile; wp_reset_query(); ?>
                    </div><!-- news -->
                </div>
            </div><!-- blue-box -->
        <?php endif; ?>
    </div><!-- container -->
    
    <div class="box">
        <div class="footer">
            <?php
                while(has_sub_field('footer_menus' ,'options')):
                $menu = get_sub_field('footer_menu');
            ?>
                <div class="column1st">
                    <h5><?php echo $menu->name; ?> <span class="icon-plus"></span></h5>
                    <?php wp_nav_menu(array('menu' => $menu->name, 'items_wrap' => '<ul class="footer-accordion-content">%3$s</ul>', 'container' => false, 'walker' => new clean_walker)); ?>
                </div><!-- column1st -->
            <?php endwhile; ?>

            <div class="clear"></div>

            <p>&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved &bull; <a href="http://www.fl1digital.com" title="Website by FL1 Digital" target="_blank">Website by FL1 Digital</a> </p>
        </div><!-- footer -->
    </div>

	<?php wp_footer(); ?>

    <script type="text/javascript">
        var __lc = {};
        __lc.license = 4674461;

        (function() {
            var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
            lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
        })();
    </script>
</body>
</html>
