<?php

/***************************************************************


Hooks


 ***************************************************************/

namespace App\Hooks;

/* ========================================

Customize main query

======================================== */

function theme_custom_query($query)
{
    if (is_admin() && !$query->is_main_query()) {
        return;
    }
    // if ($query->is_tax('custom-tax')) {
    //     $query->set('post_type', 'custom');
    // }
}
add_action('pre_get_posts', 'App\Hooks\theme_custom_query');

/* ========================================

Body Class

======================================== */
function theme_add_body_classes($classes)
{
    if (is_front_page()) {
        return array_merge($classes, array('is-front-page'));
    }
    return ($classes);
}
add_filter('body_class', 'App\Hooks\theme_add_body_classes', 10, 1);

/* ========================================

Customize redirect

======================================== */

/**
 * 不要なページを404
 */
function custom_handle_404()
{
    global $wp_query;
    if (
        is_author()
        || is_attachment()
    ) {
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
    }
}
add_action('template_redirect', 'App\Hooks\custom_handle_404');

/* ========================================

ページタイトルの調整

======================================== */
const TITLE_SEP = ' | ';
/**
 * タイトルタグのセパレーターを変更
 */
function change_title_sep($sep)
{
    $sep = trim(TITLE_SEP);
    return $sep;
}
add_filter('document_title_separator', 'App\Hooks\change_title_sep', 10, 1);

/**
 * タイトルを調整
 */
function control_document_title($title)
{

    $post_types = array('post');
    if (is_singular($post_types) || is_tax()) {
        $post_type = get_post_type() ?: get_query_var('post_type');
        $post_type_name = '';
        if ($post_type && $post_type_obj = get_post_type_object($post_type)) {
            $post_type_name = esc_html($post_type_obj->label);
        }
        $title['title'] .= TITLE_SEP . $post_type_name;
    }

    return $title;
}
add_filter('document_title_parts', 'App\Hooks\control_document_title', 10, 1);

/* ========================================

抜粋の調整

======================================== */

/**
 * 抜粋の最後の文字を調整
 */
function custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'App\Hooks\custom_excerpt_more');

/**
 * 抜粋の文字数変更
 */
function custom_excerpt_content($postContent)
{
    $postContent = mb_strimwidth($postContent, 0, 200, "…", "UTF-8");
    return $postContent;
}
add_filter('the_excerpt', 'App\Hooks\custom_excerpt_content');
