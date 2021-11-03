<?php

/***************************************************************


General Setting


 ***************************************************************/

namespace App\Setting;
use App\Helper;

function add_feature_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'App\Setting\add_feature_supports');

/* ========================================

Customize thumbnails

======================================== */
function update_media_thumbnails()
{
    // update defaults
    update_option('medium_large_size_w', 0);
    update_option('medium_large_size_w', 0);
    update_option('thumbnail_size_w', 320);
    update_option('thumbnail_size_h', 320);
    update_option('medium_size_w', 640);
    update_option('medium_size_h', 640);
    update_option('large_size_w', 1280);
    update_option('large_size_h', 1280);
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');

    // custom thumbnails
    add_image_size('thumb-for-admin-auto', 100, 100, false);
    add_image_size('post-thumbnail', 300, 300, true);
}
add_action('after_setup_theme', 'App\Setting\update_media_thumbnails');

/* ========================================

Customize wp head

======================================== */

function custom_wp_head()
{
    remove_action('wp_head', 'wp_generator'); // generator
    remove_action('wp_head', 'wlwmanifest_link'); //wlwmanifest.xml
    remove_action('wp_head', 'rsd_link'); //RPC用XML
    remove_action('wp_head', 'feed_links', 2); // 投稿フィード、コメントフィードを消去
    remove_action('wp_head', 'feed_links_extra', 3); // その他フィードを消去

    // 絵文字機能削除
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'App\Setting\custom_wp_head');



/**
 * Enqueue CSS / JS
 */
function enqueue_frontend_asstes()
{
    //remove jQuery
    wp_deregister_script('jquery');

    $temp_url = get_stylesheet_directory_uri();
    $temp_path = get_stylesheet_directory();

    //CSS
    $css_path = '/css/main.css';
    wp_enqueue_style(
        'app',
        $temp_url . $css_path,
        array(),
        Helper\get_filetime($temp_path . $css_path)
    );
   
    //js
    $js_main_path = '/js/main.js';
    wp_enqueue_script('app', $temp_url . $js_main_path, null, Helper\get_filetime($temp_path . $js_main_path), false);
}

add_action('wp_enqueue_scripts', 'App\Setting\enqueue_frontend_asstes');


/**
 * Add `defer` attribute in script tag
 */
function customize_script_load_tag($tag, $handle)
{
    if ($handle !== 'app') {
        return $tag;
    }
    return str_replace(' src=', ' defer src=', $tag);
}
add_filter('script_loader_tag', 'App\Setting\customize_script_load_tag', 10, 2);
