<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <?php get_template_part('template-parts/header'); ?>
        <div id="content" class="site-content">
            <main id="main" class="site-main">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/content', get_post_format());
                    endwhile;
                    the_posts_navigation();
                else :
                    get_template_part('template-parts/content', 'none');
                endif;
                ?>
            </main><!-- #main -->
        </div><!-- #content -->
        <?php get_template_part('template-parts/footer'); ?>
    </div><!-- #page -->
    <?php wp_footer(); ?>
</body>
</html>