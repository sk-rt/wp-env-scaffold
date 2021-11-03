<?php

/***************************************************************


Admin


 ***************************************************************/

namespace App\Admin;

/* ========================================

投稿機能のカスタム

======================================== */

/**
 * 投稿の機能を追加・削除
 */
function handle_post_supports()
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
add_action('init', 'App\Admin\handle_post_supports');

/**
 * 投稿からカテゴリ・タグの削除
 */
function remove_tax_from_post()
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
add_action('init', 'App\Admin\remove_tax_from_post');

/**
 * カテゴリーの順番が変わるの機能を削除
 */
function category_terms_checklist_no_top($args, $post_id = null)
{
    $args['checked_ontop'] = false;
    return $args;
}
add_action('wp_terms_checklist_args', 'App\Admin\category_terms_checklist_no_top');

/**
 * 記事作成時のタイトルを変更
 */
function rename_post_title_placeholder($input)
{
    if (is_admin()) {
        if (get_post_type() === 'post') {
            return '記事タイトルを入力';
        }
    }
    return $input;
}
add_filter('enter_title_here', 'App\Admin\rename_post_title_placeholder');



/**
 * 画像の「説明」フィールドを非表示
 */
function hide_attachment_description()
{
?>
    <style>
        .attachment-details .setting[data-setting="description"],
        .acf-field-gallery .acf-field-textarea[data-name="description"] {
            display: none;
        }
    </style>
<?php
}
add_action('admin_print_styles', 'App\Admin\hide_attachment_description');

/* ========================================

メニューのカスタム

======================================== */
/**
 * 左メニューから削除
 */
function remove_menu()
{
    remove_menu_page('edit-comments.php'); // コメント削除
}
add_action('admin_menu', 'App\Admin\remove_menu');

/**
 * 左メニューに 固定ページ編集リンク 追加
 */
function add_custon_page_menu()
{
    $front_page_id = get_option('page_on_front');
    if (!$front_page_id) {
        return;
    }
    $page = get_post($front_page_id);
    if ($page) {
        $path = get_edit_post_link($page->ID);
        add_menu_page("top", get_the_title($page), 'edit_pages', $path, false, 'dashicons-admin-home', '4');
    }
}
add_action('admin_menu', 'App\Admin\add_custon_page_menu');


/**
 * Admin barからメニューを削除
 */
function remove_bar_menus($wp_admin_bar)
{
    $wp_admin_bar->remove_menu('comments'); // コメント
    $wp_admin_bar->remove_menu('new-content'); // 新規
    $wp_admin_bar->remove_menu('customize'); // カスタマイズ
}
add_action('admin_bar_menu', 'App\Admin\remove_bar_menus');

/**
 * `投稿` のラベルを変更
 */
function update_post_label($labels)
{
    $post_label = __("News");
    $def_label = __(get_post_type_object('post')->label);
    $def_label_singular = __(get_post_type_object('post')->labels->singular_name);
    foreach ($labels as $key => &$label) {
        $label = str_replace($def_label, $post_label, $label);
        $label = str_replace($def_label_singular, $post_label, $label);
    }
    return $labels;
}
add_filter('post_type_labels_post', 'App\Admin\update_post_label', 10, 1);
