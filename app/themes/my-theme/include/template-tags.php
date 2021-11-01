<?php

/***************************************************************


Functions for template 


 ***************************************************************/

namespace App\CustomTags;

/**
 * クエリパラメータを除外canonicalURL取得
 */
function get_the_canonical_url()
{
    if (is_404()) {
        return home_url('/');
    }
    $full_uri = $_SERVER["REQUEST_URI"];
    $path = parse_url($full_uri, PHP_URL_PATH);
    return esc_url((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $path);
}

/**
 * ブログトップ URL取得
 */
function get_blog_home_url()
{
    if (get_option('page_for_posts')) {
        $blog_index = get_post(get_option('page_for_posts'));
        return get_permalink($blog_index->ID);
    } else {
        return home_url();
    }
}


/* ========================================

SEO

======================================== */

/**
 * OGP画像取得
 */
function get_the_ogimage_url()
{
    $def_image = get_stylesheet_directory_uri() . '/site-icons/ogp.png';
    if (is_single() || is_page()) {
        global $post;
        $postid = $post->ID;
        if (get_the_post_thumbnail($postid)) {
            $image_id = get_post_thumbnail_id($postid);
            $image = wp_get_attachment_image_src($image_id, 'large', true);
            return $image[0];
        }
    }
    return $def_image;
}

/**
 * Description 取得
 */
function get_the_description()
{
    if (is_front_page()) {
        return get_bloginfo('description');
    }
    if (is_single() || is_page()) {
        global $post;
        setup_postdata($post);
        if ($excerpt = get_the_excerpt()) {
            return $excerpt;
        } else {
            return get_the_title() . '｜' . get_bloginfo('description');
        }
        wp_reset_postdata();
    } else {
        return get_bloginfo('description');
    }
}
/**
 * Share文言 取得
 */
function util_get_share_text()
{
    return wp_title('｜', false, 'right') . get_bloginfo('name');
}
/* ========================================

ショートコード

======================================== */
/**
 * theme url
 */
add_shortcode('tempUrl', function () {
    return get_template_directory_uri() . '/';
});
/**
 * home url
 */
add_shortcode('homeUrl', function () {
    return home_url('/');
});

/**
 * WPの `get_template_part()` ショートコード
 * [template temp="temp-path"]
 */
add_shortcode('template', function ($atts) {
    $atts = shortcode_atts(
        array(
            'temp' => '',
        ),
        $atts
    );
    $temp_path = 'template-parts/' . esc_attr($atts['temp']);
    $view = get_template_part_html($temp_path);
    return $view;
});

/* ========================================

Global ナビ

======================================== */
function get_navi_arr()
{
    return array(
        array(
            'name' => 'about',
            'permalink' => home_url('/about/'),
            'label' => 'About',
            'nav-slug' => '/about',
            'disabled' => false,
        ),
        array(
            'name' => 'news',
            'permalink' => home_url('/news/'),
            'label' => 'News',
            'nav-slug' => '/news',
            'disabled' => false,
        ),
        array(
            'name' => 'contact',
            'permalink' => home_url('/contact/'),
            'label' => 'Contact',
            'nav-slug' => '/contact',
            'disabled' => false,
        ),
    );
}
