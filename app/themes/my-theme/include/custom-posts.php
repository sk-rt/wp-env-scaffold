<?php

/***************************************************************

Custom Post / Custom Taxonomy

@see https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_post_type
@see https://developer.wordpress.org/resource/dashicons/

 ***************************************************************/

namespace App\CustomPost;

add_action('init', 'App\CustomPost\register_custom');

function register_custom()
{

    /**
     * カスタム投稿
     */
    register_post_type(
        'custom',
        array(
            'labels' => array(
                'name' => __('カスタム投稿'),
                'all_items' => __('カスタム投稿一覧'),
                'add_new_item' => __('カスタム投稿を追加'),
                'edit_item' => __('カスタム投稿の編集'),
            ),
            'public' => true,
            'show_ui' => true,
            'hierarchical' => false,
            'publicly_queryable' => true,
            'menu_icon' => 'dashicons-media-document',
            'has_archive' => true,
            'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
            'menu_position' => 5,
            'show_in_rest' => true,
            'rewrite' => array('with_front' => false),
        )
    );
    /**
     * カスタム分類
     */
    register_taxonomy(
        'custom-tax',
        'custom',
        array(
            'label' => __('カスタム分類'),
            'public' => true,
            'show_ui' => true,
            'show_in_quick_edit' => true,
            'show_admin_column' => true,
            'description' => __('カスタム分類'),
            'hierarchical' => true,
            'rewrite' => array(
                'with_front' => true,
                'hierarchical' => false,
            ),
        )
    );
}
