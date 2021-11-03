<?php

/**
 * ACF Post Meta
 */
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(
        array(
            'key' => 'group_post',
            'title' => '投稿者',
            'fields' => array(
                array(
                    'key' => 'field_sub_title',
                    'label' => 'サブタイトル',
                    'name' => 'sub_title',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'side',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        )
    );
endif;
