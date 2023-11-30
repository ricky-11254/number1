<?php

function benzin_slider_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'checkbox',
        'settings'    => 'benzin_slider_display',
        'label'       => __('Display Slider ?', 'benzin'),
        'section'     => 'benzin_slider_section',
        'priority'    => 10,
        'default'     => false,
    );

    $fields[] = array(
        'type'        => 'select',
        'settings'    => 'select_cat',
        'label'       => __('Slider Category', 'benzin'),
        'description' => __('Select your Category', 'benzin'),
        'section'     => 'benzin_slider_section',
        // 'multiple'    => 999,
        'default'     => 0,
        'priority'    => 10,
        'choices'     => Kirki_Helper::get_terms('category'),
        'active_callback'  => [
            [
                'setting'  => 'benzin_slider_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );

    $fields[] = array(
        'type'        => 'number',
        'settings'    => 'slider_blog_number',
        'label'       => esc_html__('Slider to show', 'benzin'),
        'section'     => 'benzin_slider_section',
        'default'     => 3,
        'choices'     => [
            'min'  => 0,
            'max'  => 20,
            'step' => 1,
        ],
        'active_callback'  => [
            [
                'setting'  => 'benzin_slider_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'select',
        'settings'    => 'order_setting',
        'label'       => esc_html__('Order', 'benzin'),
        'section'     => 'benzin_slider_section',
        'default'     => 'DESC',
        'placeholder' => esc_html__('Select an option...', 'benzin'),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            'DESC' => esc_html__('DESC', 'benzin'),
            'ASC' => esc_html__('ASC', 'benzin'),
        ],
        'active_callback'  => [
            [
                'setting'  => 'benzin_slider_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'select',
        'settings'    => 'order_by_setting',
        'label'       => esc_html__('Order by', 'benzin'),
        'section'     => 'benzin_slider_section',
        'default'     => 'date',
        'placeholder' => esc_html__('Select an option...', 'benzin'),
        'priority'    => 10,
        'multiple'    => 1,
        'choices'     => [
            'date' => esc_html__('date', 'benzin'),
            'ID' => esc_html__('ID', 'benzin'),
            'author' => esc_html__('author', 'benzin'),
            'title' => esc_html__('title', 'benzin'),
            'name' => esc_html__('name', 'benzin'),
            'rand' => esc_html__('rand', 'benzin'),
        ],
        'active_callback'  => [
            [
                'setting'  => 'benzin_slider_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_slide_color',
        'label'       => __('Slider Opacity Background', 'benzin'),
        'section'     => 'benzin_slider_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'refresh',
        'output' => array(
            array(
                'element'  => '.header_style_2 .home-slider .single-slider::before',
                'property' => 'background',
            ),
        ),
        'active_callback'  => [
            [
                'setting'  => 'benzin_slider_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );





    $fields[] = array(
        'type'        => 'hidden',
        'settings'    => 'benzin_slider_hidden',
        'section'    => 'benzin_slider_section',

    );



    return $fields;
}
add_filter('kirki/fields', 'benzin_slider_customizer_fields');
