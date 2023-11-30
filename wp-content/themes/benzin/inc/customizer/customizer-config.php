<?php

/***
 * Theme Options customizer options
 * 
 * 
 */
function benzin_theme_options_customizer_sections($wp_customize)
{
    /**
     * Add panels
     */
    $wp_customize->add_panel('benzin_theme_customizer', array(
        'priority'    => 10,
        'title'       => __('Benzin Theme Options', 'benzin'),
    ));

    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_topbar_settings_section', array(
        'title'       => __('Header Topbar Settings', 'benzin'),
        'priority'    => 11,
        'panel'       => 'benzin_theme_customizer',
    ));




    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_excerpt_settings_section', array(
        'title'       => __('Excerpt Length Settings', 'benzin'),
        'priority'    => 13,
        'panel'       => 'benzin_theme_customizer',
    ));
    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_read_more_settings_section', array(
        'title'       => __('Read More Settings', 'benzin'),
        'priority'    => 14,
        'panel'       => 'benzin_theme_customizer',
    ));

    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_color_settings_section', array(
        'title'       => __('Color Settings', 'benzin'),
        'priority'    => 15,
        'panel'       => 'benzin_theme_customizer',
    ));

    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_footer_settings_section', array(
        'title'       => __('Footer Settings', 'benzin'),
        'priority'    => 16,
        'panel'       => 'benzin_theme_customizer',
    ));
}
add_action('customize_register', 'benzin_theme_options_customizer_sections');


/***
 * Front Page customizer options
 * 
 * 
 */
function benzin_front_page_customizer_sections($wp_customize)
{
    /**
     * Add panels
     */
    $wp_customize->add_panel('benzin_frontpage_customizer', array(
        'priority'    => 100,
        'title'       => __('Front Page Sections', 'benzin'),
    ));

    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_slider_section', array(
        'title'       => __('Slider posts', 'benzin'),
        'priority'    => 18,
        'panel'       => 'benzin_frontpage_customizer',
    ));
    /**
     * Add sections
     */
    $wp_customize->add_section('benzin_posts_section', array(
        'title'       => __('Latest posts', 'benzin'),
        'priority'    => 19,
        'panel'       => 'benzin_frontpage_customizer',
    ));
}
add_action('customize_register', 'benzin_front_page_customizer_sections');


//Theme Options Topbar Settings
get_template_part('inc/customizer/customizer-theme-options/theme-topbar');



//Theme Options excerpt Settings
get_template_part('inc/customizer/customizer-theme-options/theme-excerpt');

//Theme Options readmore Settings
get_template_part('inc/customizer/customizer-theme-options/theme-readmore');

//Theme Options Color Settings
get_template_part('inc/customizer/customizer-theme-options/theme-color');

//Theme Options Footer Settings
get_template_part('inc/customizer/customizer-theme-options/theme-footer');

//Front page banner section Settings
get_template_part('inc/customizer/customizer-frontpage/frontpage-slider');

//Front page posts section Settings
get_template_part('inc/customizer/customizer-frontpage/frontpage-posts');
