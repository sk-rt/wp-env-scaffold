<?php
/***************************************************************

Custom Queries

 ***************************************************************/
/* ========================================

クエリの変更

======================================== */

function my_custom_query($query)
{
    if (is_admin() && !$query->is_main_query()) {
        return;
    }
    if ($query->is_tax('genre')) {
        $query->set('post_type', 'custom');
    }
}
add_action('pre_get_posts', 'my_custom_query');

/* ========================================

Body Class

======================================== */
function my_add_body_classes($classes)
{
    if (is_front_page()) {
        return array_merge($classes, array('is-front-page'));
    }
    return ($classes);
}
add_filter('body_class', 'my_add_body_classes', 10, 1);

/* ========================================

ページテンプレートの調整

======================================== */

/**
 * 不要なページを404
 */
function my_custom_handle_404()
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
add_action('template_redirect', 'my_custom_handle_404');

/* ========================================

抜粋の調整

======================================== */

/**
 * 抜粋の最後の文字を調整
 */
function my_custom_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'my_custom_excerpt_more');

/**
 * 抜粋の文字数変更
 */
function my_the_excerpt($postContent)
{
    $postContent = mb_strimwidth($postContent, 0, 200, "…", "UTF-8");
    return $postContent;
}
add_filter('the_excerpt', 'my_the_excerpt');

/* ========================================

embed youtube フォーマット変更
Classic editor用

======================================== */

function my_custom_youtube_oembed($code)
{
    if (strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false || strpos($code, 'vimeo') !== false) {
        $param = "rel=0";
        $html = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&$param", $code);
        $html = '<div class="c-iframe-video"><div class="c-iframe-video__inner">' . $html . '</div></div>';
        return $html;
    }
    return $code;
}

add_filter('embed_handler_html', 'my_custom_youtube_oembed');
add_filter('embed_oembed_html', 'my_custom_youtube_oembed');
