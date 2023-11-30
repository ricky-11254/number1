<?php

function benzin_theme_excerpt_settings_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'number',
        'settings'    => 'benzin_blog_excerpt',
        'label'       => esc_html__('Excerpt Length', 'benzin'),
        'description'       => esc_html__('In words', 'benzin'),
        'section'     => 'benzin_excerpt_settings_section',
        'priority'    => 13,
        'default'     => 90,
        'choices'     => [
            'min'  => 0,
            'max'  => 220,
            'step' => 1,
        ],
    );


    return $fields;
}
add_filter('kirki/fields', 'benzin_theme_excerpt_settings_customizer_fields');
