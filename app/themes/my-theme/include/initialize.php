<?php

/***************************************************************


Initialize


 ***************************************************************/

namespace App\Initialize;

use App\Helper;

function init()
{
    add_action('admin_init', function () {
        Helper\insert_new_terms(get_requiterd_category_terms(), 'category');
        add_required_pages();
    });
}
add_action('after_switch_theme', 'App\Initialize\init');


/* ========================================

必須タームの追加

======================================== */

/**
 * カテゴリリスト
 */
function get_requiterd_category_terms()
{
    return array(
        array(
            'cat_name' => 'Cat',
            'category_nicename' => 'cat',
            'category_description' => '',
        ),
    );
}
/* ========================================

必須固定ページの追加
page_on_front,page_for_postsのアップデート

======================================== */
function add_required_pages()
{
    $toppage = get_page_by_path('top');
    if (!$toppage) {
        wp_insert_post(array(
            'post_name' => 'top',
            'post_title' => 'Top',
            'post_content' => '',
            'post_type' => 'page',
            'post_status' => 'publish',
        ));
    }
    $newspage = get_page_by_path('news');
    if (!$newspage) {
        wp_insert_post(array(
            'post_name' => 'news',
            'post_title' => 'News',
            'post_content' => '',
            'post_type' => 'page',
            'post_status' => 'publish',
        ));
    }
    $toppage = get_page_by_path('top');
    $newspage = get_page_by_path('news');
    update_option('show_on_front', 'page');
    update_option('page_on_front', $toppage->ID);
    update_option('page_for_posts', $newspage->ID);
}
