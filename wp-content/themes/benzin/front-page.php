<?php

/**
 * The template for displaying home page.
 * @package Benzin
 */

if ('posts' != get_option('show_on_front')) {
    get_header();
    /**
     * Hook - benzin_hero_blog_slider_action
     *
     * @hooked benzin_blog_post_slider - 10
     */
    do_action('benzin_hero_blog_slider_action');

    /**
     * Hook - benzin_latest_blog_posts_action
     *
     * @hooked benzin_latest_blog_posts - 10
     */
    do_action('benzin_latest_blog_posts_action');


    get_footer();
} elseif ('posts' == get_option('show_on_front')) {
    include(get_home_template());
}
