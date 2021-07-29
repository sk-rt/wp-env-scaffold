<?php
/***************************************************************

Admin

 ***************************************************************/
/* ========================================

投稿機能のカスタム

======================================== */
/**
 * 投稿の機能を追加・削除
 */
function my_handle_post_suppurt()
{
    //remove from post
    remove_post_type_support('post', 'comments');
    remove_post_type_support('post', 'trackbacks');
    remove_post_type_support('post', 'post-formats');

    //remove from page
    remove_post_type_support('page', 'comments');
    remove_post_type_support('page', 'trackbacks');

    // add excerpt to page
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'my_handle_post_suppurt');

/**
 * 投稿からカテゴリ・タグの削除
 */
function my_remove_tax_from_post()
{
    global $wp_taxonomies;
    /*
     * 投稿機能から「タグ」を削除
     */
    if (!empty($wp_taxonomies['post_tag']->object_type)) {
        foreach ($wp_taxonomies['post_tag']->object_type as $i => $object_type) {
            if ($object_type == 'post') {
                unset($wp_taxonomies['post_tag']->object_type[$i]);
            }
        }
    }
    /*
     * 投稿機能から「カテゴリ」を削除
     */
    if (!empty($wp_taxonomies['category']->object_type)) {
        foreach ($wp_taxonomies['category']->object_type as $i => $object_type) {
            if ($object_type == 'post') {
                unset($wp_taxonomies['category']->object_type[$i]);
            }
        }
    }
    return true;
};
add_action('init', 'my_remove_tax_from_post');

/**
 * カテゴリーの順番が変わるの機能を削除
 */
function my_category_terms_checklist_no_top($args, $post_id = null)
{
    $args['checked_ontop'] = false;
    return $args;
}
add_action('wp_terms_checklist_args', 'my_category_terms_checklist_no_top');

/* ========================================

メニューのカスタム

======================================== */
/**
 * 左メニューから削除
 */
function my_remove_menu()
{
    remove_menu_page('edit-comments.php'); // コメント削除
}
add_action('admin_menu', 'my_remove_menu');
/**
 * Admin barから削除
 */
function remove_bar_menus($wp_admin_bar)
{
    $wp_admin_bar->remove_menu('comments'); // コメント
    $wp_admin_bar->remove_menu('new-content'); // 新規
    $wp_admin_bar->remove_menu('customize'); // カスタマイズ
}
add_action('admin_bar_menu', 'remove_bar_menus', 500);

/**
 * `投稿` のラベルを変更
 */

add_action('post_type_labels_post', function ($labels) {
    $post_label = __("News");
    $def_label = __(get_post_type_object('post')->label);
    $def_label_singular = __(get_post_type_object('post')->labels->singular_name);
    foreach ($labels as $key => &$label) {
        $label = str_replace($def_label, $post_label, $label);
        $label = str_replace($def_label_singular, $post_label, $label);
    }
    return $labels;
}, 10, 1);

/* ========================================

エディターのカスタム

======================================== */
/**
 * 投稿画面の項目を非表示
 */
function my_remove_default_post_metaboxes()
{
    remove_meta_box('postcustom', 'post', 'normal'); // カスタムフィールド
    remove_meta_box('commentstatusdiv', 'post', 'normal'); // ディスカッション
    remove_meta_box('commentsdiv', 'post', 'normal'); // コメント
    remove_meta_box('trackbacksdiv', 'post', 'normal'); // トラックバック
    remove_meta_box('slugdiv', 'post', 'normal'); // スラッグ
    remove_meta_box('postimagediv', 'post', 'normal'); // スラッグ
    remove_meta_box('tagsdiv-post_tag', 'post', 'side'); // 投稿のタグ
}
add_action('admin_menu', 'my_remove_default_post_metaboxes');

/**
 *  固定ページのブロックエディターを無効
 */
function disable_block_editor($use_block_editor, $post_type)
{
    if ($post_type === 'page') {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'disable_block_editor', 10, 2);

/**
 * 固定ページのビジュアルエディタ無効
 */
function my_disable_visual_editor_in_page()
{
    global $typenow;
    if ($typenow == 'page') {
        add_filter('user_can_richedit', '__return_false');
    }
}
add_action('load-post.php', 'my_disable_visual_editor_in_page');
add_action('load-post-new.php', 'my_disable_visual_editor_in_page');

/**
 * 固定ページ 自動整形削除
 */
function my_remove_wpautop_filter($content)
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
add_filter('the_content', 'my_remove_wpautop_filter', 9);

/**
 * Classic editorのウィジウィグのボタンを削除
 * @see http://cly7796.net/wp/cms/delete-button-of-widgwig-at-wordpress/
 */
function remove_tinymce_buttons($buttons)
{
    $remove = array('wp_more', 'dfw', 'alignleft', 'aligncenter', 'alignright', 'bullist', 'numlist', 'spellchecker');
    return array_diff($buttons, $remove);
}
add_filter('mce_buttons', 'remove_tinymce_buttons');

/**
 * ブロックエディターの不要ブロックを削除
 */
function custom_allowed_block_types($allowed_block_types)
{

    $allowed_block_types = array(
        // 一般ブロック
        'core/paragraph', // 段落
        'core/heading', // 見出し
        'core/image', // 画像
        'core/quote', // 引用
        // 'core/gallery', // ギャラリー
        'core/list', // リスト
        // 'core/audio', // 音声
        // 'core/cover', // カバー
        'core/file', // ファイル
        // 'core/video', // 動画

        // フォーマット
        // 'core/code', // ソースコード
        // 'core/freeform', // クラシック
        'core/html', // カスタムHTML
        // 'core/preformatted', // 整形済み
        // 'core/pullquote', // プルクオート
        // 'core/table', // テーブル
        // 'core/verse', // 詩

        // レイアウト要素
        // 'core/button', // ボタン
        // 'core/columns', // カラム
        // 'core/media-text', // メディアと文章
        // 'core/more', // 続きを読む
        // 'core/nextpage', // 改ページ
        'core/separator', // 区切り
        'core/spacer', // スペーサー

        // ウィジェット
        // 'core/shortcode', // ショートコード
        // 'core/archives', // アーカイブ
        // 'core/categories', // カテゴリー
        // 'core/latest-comments', // 最新のコメント
        // 'core/latest-posts', // 最新の記事

        // 埋め込み
        'core/embed', // 埋め込み
    );
    return $allowed_block_types;
}
add_filter('allowed_block_types_all', 'custom_allowed_block_types');

/**
 *  core/embedのvariationを削除
 *  @see ./admin/js/gutenberg-custom.js
 */
function my_gutenberg_enqueue()
{
    wp_enqueue_script('myguten-script', get_stylesheet_directory_uri() . '/admin-assets/js/gutenberg-custom.js', array('wp-blocks', 'wp-dom-ready', 'wp-edit-post'), '1.0.0', false);
}
add_action('enqueue_block_editor_assets', 'my_gutenberg_enqueue');

/**
 * ブロックエディターのpatternを削除
 */
add_action('init', function() {
	remove_theme_support('core-block-patterns');
});
