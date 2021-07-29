<?php
/***************************************************************

基本設定

 ***************************************************************/
add_theme_support( 'title-tag' );
/* ========================================

画像サイズの追加・調整

======================================== */

add_theme_support('post-thumbnails');
update_option('medium_large_size_w', 0);
add_image_size('thumb-for-admin-auto', 100, 100, false);
add_image_size('post-thumbnail', 300, 300, true);

/* ========================================

wp headのカスタム

======================================== */

function my_custom_wp_head()
{
    remove_action('wp_head', 'wp_generator'); // generator
    // remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // rel="shortlink"
    remove_action('wp_head', 'wlwmanifest_link'); //wlwmanifest.xml
    remove_action('wp_head', 'rsd_link'); //RPC用XML
    remove_action('wp_head', 'feed_links', 2); // 投稿フィード、コメントフィードを消去
    remove_action('wp_head', 'feed_links_extra', 3); // その他フィードを消去
}
add_action('init', 'my_custom_wp_head');
/**
 * 　絵文字機能削除
 */
function my_disable_emoji()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'my_disable_emoji');

/**
 * テーマのCSS,JS読み込み
 */
function my_get_filetime( $filepath)
{
    if (file_exists($filepath)) {
        return filemtime($filepath);
    } else {
        return null;
    }
}
function theme_load_scripts()
{
    $temp_url = get_stylesheet_directory_uri();
    $temp_path = get_stylesheet_directory();

    //CSS読み込み
    $css_path = '/css/style.css';
    wp_enqueue_style('main',
       $temp_url . $css_path,
        array(),
        my_get_filetime($temp_path . $css_path)
    );
    //jQuery削除
    wp_deregister_script('jquery');
    //js読み込み
    $js_main_path = '/js/main.js';
    wp_enqueue_script('main',$temp_url . $js_main_path, null, my_get_filetime($temp_path . $js_main_path), false);

}

add_action('wp_enqueue_scripts', 'theme_load_scripts');

/**
 * wp_enqueue_scriptに
 * defer属性を追加
 */
function my_add_defer($tag, $handle)
{
    if ($handle !== 'main') {
        return $tag;
    }
    return str_replace(' src=', ' defer src=', $tag);
}
add_filter('script_loader_tag', 'my_add_defer', 10, 2);
