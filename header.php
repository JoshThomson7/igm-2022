<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php if(is_front_page()): ?><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?><?php else: ?><?php wp_title('-', true, 'right'); ?><?php endif; ?></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie7.css" media="screen" /><![endif]-->

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style-base.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style-custom.php" media="screen">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <?php wp_enqueue_script('jquery'); ?>
    <?php wp_head(); ?>
    
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/scripts/scripts-min.js"></script>
</head>

<body>
    <nav id="mobile_nav" class="mobile_nav">        
        <?php wp_nav_menu(array('menu' => 'Main Menu', 'items_wrap' => '<ul>%3$s</ul>', 'container' => false, 'walker' => new clean_walker)); ?>
    </nav>

    <div class="header clearfix">
        <div class="box">
            <a href="#mobile_nav" title="Navigation" class="nav-icon"><span></span><span></span><span></span></a>

            <div class="logo">
                <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
                    <img src="<?php bloginfo('stylesheet_directory'); ?>/img/new-logo.gif" alt="<?php bloginfo('name'); ?>" />
                </a>
            </div><!-- logo -->

            <div class="header-right">
                <div class="topbar clearfix">
                    <?php if(have_rows('sm_icons', 'option')): ?>
                        <div class="social">
                            <ul>
                                <?php while(have_rows('sm_icons', 'option')) : the_row(); ?>
                                    <li><a href="<?php the_sub_field('sm_url'); ?>" target="_blank" title="<?php the_sub_field('sm_platform'); ?>"><span class="<?php the_sub_field('sm_icon'); ?>"></span></a></li>
                                <?php endwhile; ?>
                            </ul>
                        </div><!-- social -->
                    <?php endif; ?>

                    <?php if(get_field('contact_phone', 27)): ?>
                        <div class="phone">
                            <span class="icon-call-out"></span>
                            <p><?php the_field('contact_branch','27'); ?>: <?php the_field('contact_phone', 27); ?></p>
                            <p><?php the_field('contact_branch2','27'); ?>: <?php the_field('contact_phone2', 27); ?></p>
                            <p><?php the_field('contact_branch3','27'); ?>: <?php the_field('contact_mobile3', 27); ?></p>
                        </div>
                    <?php endif; ?>
                </div><!-- topbar -->
            </div><!-- header-right -->
        </div>
    </div><!-- header -->

    <div class="primary-nav clearfix">
        <div class="box">
            <?php wp_nav_menu(array('menu' => 'Main Menu', 'items_wrap' => '<ul>%3$s</ul>', 'container' => false, 'walker' => new clean_walker)); ?>
        </div>
    </div><!-- navigation -->