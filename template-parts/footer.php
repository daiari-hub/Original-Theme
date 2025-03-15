<footer id="colophon" class="site-footer">
    <div class="site-info">
        <p>&copy; <?php echo date('Y'); ?> Your Site Name. All rights reserved.</p>
        <p>Powered by <a href="https://wordpress.org/">WordPress</a></p>
    </div><!-- .site-info -->
    <div class="footer-buttons">
        <?php
        $menu_locations = get_nav_menu_locations();
        $menu_id = $menu_locations['footer'];
        $footer_menu = wp_get_nav_menu_items($menu_id);

        if ($footer_menu) {
            foreach ($footer_menu as $menu_item) {
                echo '<a href="' . esc_url($menu_item->url) . '" class="footer-button">' . esc_html($menu_item->title) . '</a>';
            }
        }
        ?>
    </div><!-- .footer-buttons -->
    <div class="footer-meta">
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
        ?>
    </div><!-- .footer-meta -->
</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>