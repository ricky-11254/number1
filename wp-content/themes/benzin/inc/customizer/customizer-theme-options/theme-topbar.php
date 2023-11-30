<?php

function benzin_theme_topbar_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'checkbox',
        'settings'    => 'benzin_topbar_display',
        'label'       => __('Display Topbar ?', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'default'     => false,
    );
    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_topbar_email',
        'label'       => __('Email address', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_topbar_phone',
        'label'       => __('Phone number', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_topbar_address',
        'label'       => __('Address', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'url',
        'settings'    => 'benzin_topbar_facebook',
        'label'       => __('Facebook URL', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'url',
        'settings'    => 'benzin_topbar_instagram',
        'label'       => __('Instagram URL', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'url',
        'settings'    => 'benzin_topbar_pinterest',
        'label'       => __('Pinterest URL', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'url',
        'settings'    => 'benzin_topbar_twitter',
        'label'       => __('Twitter URL', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );


    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_topbar_quote_btn',
        'label'       => __('Get A Quote', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );
    $fields[] = array(
        'type'        => 'url',
        'settings'    => 'benzin_topbar_quote_btn_url',
        'label'       => __('Get A Quote URL', 'benzin'),
        'section'     => 'benzin_topbar_settings_section',
        'priority'    => 10,
        'active_callback'  => [
            [
                'setting'  => 'benzin_topbar_display',
                'operator' => '===',
                'value'    => true,
            ]
        ]
    );

    $fields[] = array(
        'type'        => 'hidden',
        'settings'    => 'benzin_topbar_hidden',
        'section'    => 'benzin_topbar_settings_section',

    );


    return $fields;
}
add_filter('kirki/fields', 'benzin_theme_topbar_customizer_fields');
