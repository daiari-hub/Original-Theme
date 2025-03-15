<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content();
        else :
            the_excerpt();
        endif;

        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'theme-q'),
            'after'  => '</div>',
        ));
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
        // 投稿のカテゴリーを表示
        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            printf('<span class="cat-links">' . __('Posted in %1$s', 'theme-q') . '</span>', $categories_list);
        }

        // 投稿のタグを表示
        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list) {
            printf('<span class="tag-links">' . __('Tagged %1$s', 'theme-q') . '</span>', $tags_list);
        }

        // 編集リンクを表示
        edit_post_link(
            sprintf(
                wp_kses(
                    __('Edit <span class="screen-reader-text">%s</span>', 'theme-q'),
                    array('span' => array('class' => array()))
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->