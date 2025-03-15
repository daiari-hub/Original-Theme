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
                <?php mytheme_breadcrumb(); // パンくずリストを表示 ?>
                <?php
                while (have_posts()) :
                    the_post();
                    // ヘッダー画像を表示
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('class' => 'post-header-image'));
                    }
                    get_template_part('template-parts/content', get_post_format());

                    // ページ訪問数を表示
                    echo '<p>' . mytheme_get_post_views(get_the_ID()) . '</p>';

                    // 投稿ナビゲーション
                    the_post_navigation(array(
                        'prev_text' => '<span class="nav-subtitle">' . __('Previous:', 'theme-q') . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . __('Next:', 'theme-q') . '</span> <span class="nav-title">%title</span>',
                    ));

                    // コメントテンプレート
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile;
                ?>
            </main><!-- #main -->
        </div><!-- #content -->
        <?php get_template_part('template-parts/footer'); ?>
    </div><!-- #page -->
    <?php wp_footer(); ?>
</body>
</html>