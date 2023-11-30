<?php

function benzin_theme_color_settings_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_header_topbar_color',
        'label'       => __('Header Topbar Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => '.header_style_2 .toolbar-area',
                'property' => 'background-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_header_menubar_color',
        'label'       => __('Header Menu bar Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#ffff',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => '.header_style_2 .header-menu-area .header-main-menu',
                'property' => 'background-color',
            ),
        ),
    );


    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_button_background_color',
        'label'       => __('Primary Button Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => 'body .main-btn-blue, .blog-post-sidebar .search-form .search-submit, .wp-block-search__button, .header_style_2 .home-slider .slick-dots li.slick-active button, .page-numbers.current, a.page-numbers:hover',
                'property' => 'background-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_button_border_color',
        'label'       => __('Button border color', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => 'body .main-btn-blue, .blog-post-sidebar .search-form .search-submit, .wp-block-search__button ',
                'property' => 'border-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_header_background',
        'label'       => __('Header Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => '.breadcrumbs_section::before',
                'property' => 'background-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_body_color',
        'label'       => __('Body Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#fff',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => 'body',
                'property' => 'background-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_footer_color',
        'label'       => __('Footer Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#282B30',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => '.footer_style2',
                'property' => 'background-color',
            ),
        ),
    );
    $fields[] = array(
        'type'        => 'color',
        'settings'    => 'benzin_footer_bottom_color',
        'label'       => __('Footer Copyrite Background', 'benzin'),
        'section'     => 'benzin_color_settings_section',
        'priority'    => 10,
        'default'     => '#2455E6',
        'transport'   => 'postMessage',
        'output' => array(
            array(
                'element'  => '.footer_style2 .footer-copyright',
                'property' => 'background-color',
            ),
        ),
    );

    return $fields;
}
add_filter('kirki/fields', 'benzin_theme_color_settings_customizer_fields');
