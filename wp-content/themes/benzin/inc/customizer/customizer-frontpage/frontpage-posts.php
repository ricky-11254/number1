<?php

function benzin_posts_customizer_fields($fields)
{

    $fields[] = array(
        'type'        => 'checkbox',
        'settings'    => 'benzin_latestposts_display',
        'label'       => __('Display Latest posts ?', 'benzin'),
        'section'     => 'benzin_posts_section',
        'priority'    => 10,
        'default'     => false,
    );


    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_latest_section_title',
        'label'       => __('Section Title', 'benzin'),
        'section'     => 'benzin_posts_section',
        'default'     => 'Latest Posts title',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_latestposts_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'select',
        'settings'    => 'benzin_latest_post_category',
        'label'       => __('Select Category', 'benzin'),
        'description' => __('Select your post', 'benzin'),
        'section'     => 'benzin_posts_section',
        // 'multiple'    => 999,
        'default'     => 0,
        'priority'    => 10,
        'choices'     => Kirki_Helper::get_terms('category'),
        'active_callback'  => [
            [
                'setting'  => 'benzin_latestposts_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );

    $fields[] = array(
        'type'        => 'number',
        'settings'    => 'benzin_latest_post_number',
        'label'       => esc_html__('Number of Posts', 'benzin'),
        'description' => __('Maximum number of post to show is 6.', 'benzin'),
        'section'     => 'benzin_posts_section',
        'default'     => 6,
        'choices'     => [
            'min'  => 0,
            'max'  => 20,
            'step' => 1,
        ],
        'active_callback'  => [
            [
                'setting'  => 'benzin_latestposts_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_blog_color',
        'label'       => __('Blog Section Background', 'benzin'),
        'section'     => 'benzin_posts_section',
        'priority'    => 10,
        'default'     => '#fff',
        'transport'   => 'refresh',
        'output' => array(
            array(
                'element'  => '.blog_style2',
                'property' => 'background',
            ),
        ),
        'active_callback'  => [
            [
                'setting'  => 'benzin_latestposts_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );


    $fields[] = array(
        'type'        => 'hidden',
        'settings'    => 'benzin_latestposts_hidden',
        'section'    => 'benzin_posts_section',

    );



    return $fields;
}
add_filter('kirki/fields', 'benzin_posts_customizer_fields');
