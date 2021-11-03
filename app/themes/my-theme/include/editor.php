<?php

/***************************************************************


Editor


 ***************************************************************/

namespace App\Editor;
use App\Helper;

/* ========================================

Classic editor

======================================== */
/**
 * Remove Metabox
 */
function remove_default_post_metaboxes()
{
    remove_meta_box('postcustom', 'post', 'normal'); // カスタムフィールド
    remove_meta_box('commentstatusdiv', 'post', 'normal'); // ディスカッション
    remove_meta_box('commentsdiv', 'post', 'normal'); // コメント
    remove_meta_box('trackbacksdiv', 'post', 'normal'); // トラックバック
    remove_meta_box('slugdiv', 'post', 'normal'); // スラッグ
    remove_meta_box('postimagediv', 'post', 'normal'); // スラッグ
    remove_meta_box('tagsdiv-post_tag', 'post', 'side'); // 投稿のタグ
}
add_action('admin_menu', 'App\Editor\remove_default_post_metaboxes');

/**
 * 固定ページのビジュアルエディタ無効
 */
function disable_visual_editor_in_page()
{
    global $typenow;
    if ($typenow == 'page') {
        add_filter('user_can_richedit', '__return_false');
    }
}
add_action('load-post.php', 'App\Editor\disable_visual_editor_in_page');
add_action('load-post-new.php', 'App\Editor\disable_visual_editor_in_page');

/**
 * 固定ページ 自動整形削除
 */
function remove_wpautop_filter($content)
{
    global $post;
    $remove_filter = false;
    $arr_types = array('page');
    $post_type = get_post_type($post->ID);
    if (in_array($post_type, $arr_types)) {
        $remove_filter = true;
    }
    if ($remove_filter) {
        remove_filter('the_content', 'wpautop');
        remove_filter('the_excerpt', 'wpautop');
    }
    return $content;
}
add_filter('the_content', 'App\Editor\remove_wpautop_filter');

/**
 * Classic editorのビジュアルエディタのウィジウィグのボタンを削除
 * @see http://cly7796.net/wp/cms/delete-button-of-widgwig-at-wordpress/
 */
function remove_tinymce_buttons($buttons)
{
    $remove = array('wp_more', 'dfw', 'alignleft', 'aligncenter', 'alignright', 'bullist', 'numlist', 'spellchecker');
    return array_diff($buttons, $remove);
}
add_filter('mce_buttons', 'App\Editor\remove_tinymce_buttons');

/**
 * Classic editorのテキストディタのボタン削除
 */
function remove_html_editor_buttons($qt_init)
{
    // 削除するボタンを指定
    $remove = array(
        // 'strong', // b
        'em', // i
        // 'link',   // link
        'block', // b-quote
        // 'del',    // del
        'ins', // ins
        'img', // img
        'ul', // ul
        'ol', // ol
        'li', // li
        'code', // code
        'more', // more
        // 'close',  // タグを閉じる
        // 'dfw',    // 集中執筆モード
    );
    // ボタンの一覧を文字列から配列に分割
    $qt_init['buttons'] = explode(',', $qt_init['buttons']);
    // 指定したボタンを削除
    $qt_init['buttons'] = array_diff($qt_init['buttons'], $remove);
    // 配列から文字列に連結
    $qt_init['buttons'] = implode(',', $qt_init['buttons']);
    return $qt_init;
}
add_filter('quicktags_settings', 'App\Editor\remove_html_editor_buttons');

/**
 * Classic editorのembed youtube フォーマット変更
 */
// function custom_youtube_oembed($code)
// {
//     if (strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false || strpos($code, 'vimeo') !== false) {
//         $param = "rel=0";
//         $html = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&$param", $code);
//         $html = '<div class="c-iframe-video"><div class="c-iframe-video__inner">' . $html . '</div></div>';
//         return $html;
//     }
//     return $code;
// }
// add_filter('embed_handler_html', 'App\Editor\custom_youtube_oembed');
// add_filter('embed_oembed_html', 'App\Editor\custom_youtube_oembed');

/* ========================================

Block editor

======================================== */

/**
 * Remove block-library/style.min.css
 */
function dequeue_block_library_css()
{
    // 投稿詳細ページのみblock-library/style.min.cssを読み込み
    if (!is_singular('post')) {
        wp_dequeue_style('wp-block-library');
    }
}
add_action('wp_enqueue_scripts', 'App\Editor\dequeue_block_library_css');

/**
 *  Load JS/CSS for block editor
 */
function enqueue_cutomize_block_editor_assets()
{
    $temp_url = get_stylesheet_directory_uri();
    $temp_path = get_stylesheet_directory();
    // JS
    $js_path = '/js/admin-editor.js';
    wp_enqueue_script(
        'custom-editor-script',
        $temp_url .  $js_path,
        array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'),
        Helper\get_filetime($temp_path . $js_path),
        false
    );
    // CSS
    $css_path = '/css/admin-editor.css';
    wp_enqueue_style(
        'custom-editor-style',
        $temp_url .  $css_path,
        ['wp-edit-blocks'],
        Helper\get_filetime($temp_path . $css_path)
    );
}
add_action('enqueue_block_editor_assets', 'App\Editor\enqueue_cutomize_block_editor_assets');



/**
 * Disable block editor
 * @param boolean $use_block_editor
 * @param string $post_type
 * @return boolean
 */
function disable_block_editor($use_block_editor, $post_type)
{
    // 固定ページではブロックエディターを使用しない
    if ($post_type === 'page') {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'App\Editor\disable_block_editor', 10, 2);


/**
 * 使用するブロックを指定
 */
function filter_allowed_block_types($allowed_block_types)
{
    $allowed_block_types = array(
        // ------- design -------
        // 'core/button', // Button
        'core/buttons', // Buttons
        // 'core/columns', // Columns
        // 'core/group', // Group
        // 'core/more', // More
        // 'core/nextpage', // Page Break
        // 'core/post-template', // Post Template
        // 'core/post-terms', // Post Terms
        // 'core/query-pagination', // Query Pagination
        // 'core/query-pagination-next', // Query Pagination Next
        // 'core/query-pagination-numbers', // Query Pagination Numbers
        // 'core/query-pagination-previous', // Query Pagination Previous
        // 'core/query-title', // Query Title
        'core/separator', // Separator
        // 'core/site-tagline', // Site Tagline
        // 'core/site-title', // Site Title
        // 'core/spacer', // Spacer
        // 'core/text-columns', // Text Columns (deprecated)
        // ------ embed -------
        'core/embed', // Embed
        // -------layout -------
        // 'core/site-logo', // Site Logo
        // ------ media -------
        // 'core/audio', // Audio
        // 'core/cover', // Cover
        // 'core/file', // File
        // 'core/gallery', // Gallery
        'core/image', // Image
        // 'core/media-text', // Media & Text
        // 'core/video', // Video
        // ---------usable -------
        // 'core/block', // Reusable block
        // ------ text -------
        // 'core/code', // Code
        // 'core/column', // Column
        // 'core/freeform', // Classic
        'core/heading', // Heading
        'core/list', // List
        // 'core/missing', // Unsupported
        'core/paragraph', // Paragraph
        // 'core/preformatted', // Preformatted
        // 'core/pullquote', // Pullquote
        'core/quote', // Quote
        // 'core/table', // Table
        // 'core/verse', // Verse
        // ------ theme -------
        // 'core/loginout', // Login/out
        // 'core/post-content', // Post Content
        // 'core/post-date', // Post Date
        // 'core/post-excerpt', // Post Excerpt
        // 'core/post-featured-image', // Post Featured Image
        // 'core/post-title', // Post Title
        // 'core/query', // Query Loop
        // -------- widgets -------
        // 'core/archives', // Archives
        // 'core/calendar', // Calendar
        // 'core/categories', // Categories
        // 'core/html', // Custom HTML
        // 'core/latest-comments', // Latest Comments
        // 'core/latest-posts', // Latest Posts
        // 'core/legacy-widget', // Legacy Widget
        // 'core/page-list', // Page List
        // 'core/rss', // RSS
        // 'core/search', // Search
        // 'core/shortcode', // Shortcode
        // 'core/social-link', // Social Icon
        // 'core/social-links', // Social Icons
        // 'core/tag-cloud', // Tag Cloud
    );
    return $allowed_block_types;
}
add_filter('allowed_block_types_all', 'App\Editor\filter_allowed_block_types');


/**
 * ブロックエディターの設定の上書き
 * @param array $editor_settings
 * @param array $editor_context
 * @return array
 */
function filter_block_editor_settings($editor_settings, $editor_context)
{
    Helper\debug_log($editor_settings);

    // align full / align wide を無効化
    $editor_settings['supportsLayout'] = false;
    // 画像編集の無効化
    $editor_settings['imageEditing'] = false;

    return $editor_settings;
}
add_filter('block_editor_settings_all', 'App\Editor\filter_block_editor_settings', 10, 2);

/**
 * ブロックカテゴリのフィルター
 * カテゴリを削除すると、属するブロックは Uncategorized カテゴリに入る。
 * ブロックごと削除される訳ではない。
 *
 * @param array $block_categories 全カテゴリの配列
 * @param array $editor_context
 * @return array
 */
function filter_block_categories($block_categories, $editor_context)
{
    // 全カテゴリスラッグ
    // 'text', 'media', 'design', 'widgets', 'theme', 'embed', 'reusable', 'text', 'media', 'design', 'widgets', 'theme', 'embed', 'reusable'
    $remove_categories = ['some-categoriy']; // 削除するカテゴリ
    $filterd_categories = array_filter($block_categories, function ($category) use ($remove_categories) {
        return !in_array($category['slug'], $remove_categories, true);
    });
    return $filterd_categories;
}

add_filter('block_categories_all', 'App\Editor\filter_block_categories', 10, 2);

/**
 * テーマ機能の無効化
 */
function remove_block_editor_supports()
{
    // ブロックエディターのパターンを削除
    remove_theme_support('core-block-patterns');

    // 個別にパターンの削除
    // $patterns = get_all_sorted_patterns();
    // foreach ($patterns as $pattern) {
    //     if (strpos($pattern['name'], 'core/') === 0) {
    //         unregister_block_pattern($pattern['name']);
    //     };
    // }
}
add_action('init', 'App\Editor\remove_block_editor_supports', 10);


/**
 * エディターの画像サイズのリスト
 */
function filter_editore_image_sizes($size_names)
{
    // default
    $size_names = array(
        'thumbnail' => __('Thumbnail'),
        'medium'    => __('Medium'),
        'large'     => __('Large'),
        // 'full'      => __('Full Size'),
    );
    return $size_names;
}
add_filter('image_size_names_choose', 'App\Editor\filter_editore_image_sizes');


/* ========================================

ACF wysiwyg editor

======================================== */

/**
 * ACF wysiwygにminimal追加
 */
function add_minimal_toolbar_to_acf($toolbars)
{
    $toolbars['Minimal'] = array();
    $toolbars['Minimal'][1] = array('link', 'unlink', 'bold', 'italic', 'underline', 'strikethrough', 'undo', 'redo');

    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'App\Editor\add_minimal_toolbar_to_acf');
