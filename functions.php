<?php
// テーマのセットアップ
function mytheme_setup() {
    // タイトルタグのサポートを追加
    add_theme_support('title-tag');

    // 投稿サムネイルのサポートを追加
    add_theme_support('post-thumbnails');

    // HTML5のサポートを追加
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // カスタムロゴのサポートを追加
    add_theme_support('custom-logo');

    // カスタマイザーの選択的リフレッシュウィジェットのサポートを追加
    add_theme_support('customize-selective-refresh-widgets');

    // エディタースタイルのサポートを追加
    add_theme_support('editor-styles');

    // ブロックスタイルのサポートを追加
    add_theme_support('wp-block-styles');

    // 幅広アライメントのサポートを追加
    add_theme_support('align-wide');

    // レスポンシブ埋め込みのサポートを追加
    add_theme_support('responsive-embeds');

    // エディターフォントサイズのサポートを追加
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => __('Small', 'theme-q'),
            'shortName' => __('S', 'theme-q'),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => __('Regular', 'theme-q'),
            'shortName' => __('M', 'theme-q'),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => __('Large', 'theme-q'),
            'shortName' => __('L', 'theme-q'),
            'size' => 36,
            'slug' => 'large'
        ),
        array(
            'name' => __('Huge', 'theme-q'),
            'shortName' => __('XL', 'theme-q'),
            'size' => 50,
            'slug' => 'huge'
        )
    ));

    // ナビゲーションメニューを登録
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'theme-q'),
        'footer' => __('Footer Menu', 'theme-q'),
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// スタイルとスクリプトを読み込む
function mytheme_enqueue_assets() {
    wp_enqueue_style('mytheme-styles', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_script('mytheme-scripts', get_theme_file_uri('/assets/js/script.js'), array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_assets');

// スクリプトを非同期で読み込む
function mytheme_add_async_attribute($tag, $handle) {
    if ('mytheme-scripts' !== $handle) {
        return $tag;
    }
    return str_replace(' src', ' async="async" src', $tag);
}
add_filter('script_loader_tag', 'mytheme_add_async_attribute', 10, 2);

// 不要なスクリプトやスタイルの読み込みを削除
function mytheme_dequeue_scripts() {
    // 例: jQueryを削除
    wp_dequeue_script('jquery');
}
add_action('wp_enqueue_scripts', 'mytheme_dequeue_scripts', 100);

// SEOメタタグを追加
function mytheme_add_meta_tags() {
    if (is_single() || is_page()) {
        global $post;
        $description = get_the_excerpt($post->ID);
        $description = strip_tags($description);
        $description = str_replace("\"", "'", $description);
        ?>
        <meta name="description" content="<?php echo $description; ?>">
        <meta property="og:title" content="<?php the_title(); ?>">
        <meta property="og:description" content="<?php echo $description; ?>">
        <meta property="og:type" content="article">
        <meta property="og:url" content="<?php the_permalink(); ?>">
        <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
        <meta property="og:image" content="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php the_title(); ?>">
        <meta name="twitter:description" content="<?php echo $description; ?>">
        <meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>">
        <?php
    }
}
add_action('wp_head', 'mytheme_add_meta_tags');

// JSON-LDスキーマを追加
function mytheme_add_json_ld() {
    if (is_single() || is_page()) {
        global $post;
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "Article",
            "mainEntityOfPage" => array(
                "@type" => "WebPage",
                "@id" => get_permalink()
            ),
            "headline" => get_the_title(),
            "image" => array(
                "@type" => "ImageObject",
                "url" => get_the_post_thumbnail_url($post->ID, 'full')
            ),
            "datePublished" => get_the_date('c'),
            "dateModified" => get_the_modified_date('c'),
            "author" => array(
                "@type" => "Person",
                "name" => get_the_author()
            ),
            "publisher" => array(
                "@type" => "Organization",
                "name" => get_bloginfo('name'),
                "logo" => array(
                    "@type" => "ImageObject",
                    "url" => get_theme_file_uri('/assets/images/logo.png')
                )
            ),
            "description" => get_the_excerpt()
        );
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'mytheme_add_json_ld');

// ページ訪問数を記録する関数
function mytheme_track_post_views($post_id) {
    if (!is_single()) return;

    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count, $count);
    }
}
add_action('wp_head', 'mytheme_track_post_views');

// ページ訪問数を表示する関数
function mytheme_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return '0 views';
    }
    return $count . ' views';
}

// 管理画面の投稿一覧にページ訪問数の列を追加
function mytheme_add_views_column($columns) {
    $columns['post_views'] = 'Views';
    return $columns;
}
add_filter('manage_posts_columns', 'mytheme_add_views_column');

// ページ訪問数を表示
function mytheme_display_views_column($column_name, $post_id) {
    if ($column_name === 'post_views') {
        echo mytheme_get_post_views($post_id);
    }
}
add_action('manage_posts_custom_column', 'mytheme_display_views_column', 10, 2);

// パンくずリストを生成する関数
function mytheme_breadcrumb() {
    if (!is_home()) {
        echo '<nav class="breadcrumb">';
        echo '<a href="' . home_url() . '">ホーム</a> &raquo; ';
        if (is_category() || is_single()) {
            the_category(' &raquo; ');
            if (is_single()) {
                echo ' &raquo; ';
                the_title();
            }
        } elseif (is_page()) {
            echo the_title();
        }
        echo '</nav>';
    }
}