<?php

function benzin_theme_footer_settings_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'checkbox',
        'settings'    => 'benzin_footer_bottom_display',
        'label'       => __('Display Footer ?', 'benzin'),
        'section'     => 'benzin_footer_settings_section',
        'priority'    => 13,
        'default'     => false,
    );
    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_copyright_text',
        'label'       => __('Footer Copyright Text', 'benzin'),
        'default'     => 'Copyright ',
        'section'     => 'benzin_footer_settings_section',
        'priority'    => 13,
        'active_callback'  => [
            [
                'setting'  => 'benzin_footer_bottom_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'hidden',
        'settings'    => 'benzin_footer_bottom_hidden',
        'section'    => 'benzin_footer_settings_section',

    );

    return $fields;
}
add_filter('kirki/fields', 'benzin_theme_footer_settings_customizer_fields');
