<?php

function benzin_theme_readmore_settings_customizer_fields($fields)
{
    $fields[] = array(
        'type'        => 'text',
        'settings'    => 'benzin_blog_read_more',
        'label'       => __('Read More Text', 'benzin'),
        'default'     => 'Read more',
        'section'     => 'benzin_read_more_settings_section',
        'priority'    => 14,
    );


    return $fields;
}
add_filter('kirki/fields', 'benzin_theme_readmore_settings_customizer_fields');
