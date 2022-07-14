                <div class="sidebar">
                    <div class="featured clearfix">
                    	<ul>
                    		<?php 
        		                while(has_sub_field('home_boxes', 2)):
        		                $attachment_id = get_sub_field('home_box_image');
        		                $box_image = vt_resize($attachment_id,'' , 100, 60, true);
        		            ?>
        	                	<li>
        	                    	<a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_heading'); ?>" class="featured-img"><img src="<?php echo $box_image[url]; ?>" alt="<?php the_sub_field('home_box_heading'); ?>" /></a>
        	                    	<h3><a href="<?php the_sub_field('home_box_button_link'); ?>" title="<?php the_sub_field('home_box_heading'); ?>"><?php the_sub_field('home_box_heading'); ?></a></h3>
        	                    </li>
        	                <?php endwhile; ?>
                        </ul>
                    </div><!-- featured -->
                </div><!-- sidebar -->