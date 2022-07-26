    <div class="footer-container">
        <div class="max__width">
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

            </div><!-- footer -->

            <div class="subfooter">
                <p>&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved &bull; <a href="http://www.fl1digital.com" title="Website by FL1 Digital" target="_blank">Website by FL1 Digital</a> </p>
            </div>
        </div>
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
