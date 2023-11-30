<?php


/**
 * Custom Theme functions.
 * This file contains hook functions attached to theme hooks.
 * 
 * @package Benzin
 */

/**
 * Header hook function
 */

if (!function_exists('benzin_main_header')) :
    function benzin_main_header()
    { ?>

        <!--====== HEADER PART START ======-->

        <header class="header-area header_style_2">

            <div class="header-menu-area d-lg-block">

                <?php
                $benzin_topbar_display = get_theme_mod('benzin_topbar_display');
                if ('1' == $benzin_topbar_display) { ?>
                    <div class="toolbar-area">
                        <div class="container">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-lg-8 col-md-9 col-12">
                                    <div class="toolbar-contact">
                                        <?php
                                        $benzin_topbar_email = is_email(get_theme_mod('benzin_topbar_email'));
                                        $benzin_topbar_phone_number_val = preg_match('/[0-9]/', get_theme_mod('benzin_topbar_phone'));
                                        $benzin_topbar_address = get_theme_mod('benzin_topbar_address');
                                        ?>

                                        <?php if ($benzin_topbar_email) : ?>
                                            <p><i class="fas fa-envelope"></i><a href="<?php echo esc_html("mailto:", "benzin") . esc_attr($benzin_topbar_email); ?>"><?php echo esc_html($benzin_topbar_email); ?></a>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (1 == $benzin_topbar_phone_number_val) {
                                            $benzin_topbar_phone_num = get_theme_mod('benzin_topbar_phone');
                                        }

                                        if (isset($benzin_topbar_phone_num)) { ?>
                                            <p><i class="fas fa-phone-volume"></i><a href="<?php echo esc_html("tel:", "benzin") . esc_attr($benzin_topbar_phone_num); ?>"><?php echo esc_html($benzin_topbar_phone_num); ?></a>
                                            </p>
                                        <?php } ?>

                                        <?php if ($benzin_topbar_address) : ?>
                                            <p><i class="fas fa-map-marker-alt"></i> <a href=""><?php echo esc_html($benzin_topbar_address); ?></a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3 col-12">
                                    <div class="toolbar-sl-share">
                                        <?php

                                        $benzin_topbar_facebook = get_theme_mod('benzin_topbar_facebook');
                                        $benzin_topbar_instagram = get_theme_mod('benzin_topbar_instagram');
                                        $benzin_topbar_pinterest = get_theme_mod('benzin_topbar_pinterest');
                                        $benzin_topbar_twitter = get_theme_mod('benzin_topbar_twitter');
                                        ?>

                                        <ul>
                                            <?php if ($benzin_topbar_facebook) : ?>
                                                <li><a href="<?php echo esc_url($benzin_topbar_facebook); ?>"><i class="fab fa-facebook-f"></i></a></li>
                                            <?php endif; ?>
                                            <?php if ($benzin_topbar_instagram) : ?>
                                                <li><a href="<?php echo esc_url($benzin_topbar_instagram); ?>"><i class="fab fa-instagram"></i></a></li>
                                            <?php endif; ?>
                                            <?php if ($benzin_topbar_pinterest) : ?>
                                                <li><a href="<?php echo esc_url($benzin_topbar_pinterest); ?>"><i class="fab fa-pinterest-p"></i></a></li>
                                            <?php endif; ?>
                                            <?php if ($benzin_topbar_twitter) : ?>
                                                <li><a href="<?php echo esc_url($benzin_topbar_twitter); ?>"><i class="fab fa-twitter"></i></a></li>
                                            <?php endif; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }  ?>
                <?php

                $benzin_topbar_quote_btn = get_theme_mod('benzin_topbar_quote_btn');
                $benzin_topbar_quote_btn_url = get_theme_mod('benzin_topbar_quote_btn_url');

                ?>
                <div class="header-main-menu" id="benzin-head">
                    <div class="container">
                        <div class="row align-items-lg-center">
                            <div class="col-lg-2  mobile-view ">
                                <div class="menu-logo">
                                    <?php benzin_site_logo(); ?>

                                </div>
                                <!-- Mobile Toggle -->
                                <button type="button" class="menu-toggle">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <!-- Mobile Toggle -->
                            </div>
                            <div class="col-lg-<?php if (empty($benzin_topbar_quote_btn)) {
                                                    echo esc_html('10 d-flex justify-content-end');
                                                } else {
                                                    echo esc_html('8 d-flex justify-content-center');
                                                } ?> ">



                                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php echo esc_attr__('Primary Menu', 'benzin'); ?>">


                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary',
                                        'menu_id'        => 'primary-menu',
                                        'menu_class'     => 'nav-menu',
                                        'fallback_cb'    => 'benzin_primary_navigation_fallback',
                                    ));
                                    ?>
                                </nav><!-- #site-navigation -->
                            </div>
                            <?php
                            $benzin_topbar_display = get_theme_mod('benzin_topbar_display');
                            if ('1' == $benzin_topbar_display) { ?>

                                <?php if ($benzin_topbar_quote_btn) : ?>
                                    <div class="col-lg-2 text-lg-end">
                                        <div class="button">
                                            <a class="btn main-btn-blue mouse-hover" href="<?php echo esc_url($benzin_topbar_quote_btn_url); ?>"><?php echo esc_html($benzin_topbar_quote_btn); ?><span></span></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php } ?>
                        </div> <!-- row -->
                    </div> <!-- container -->

                </div>
            </div> <!-- header menu area -->





        </header>

        <!--====== HEADER PART ENDS ======-->

    <?php
    }
endif;
add_action('benzin_action_header', 'benzin_main_header', 10);


/**
Footer hook function
 **/

if (!function_exists('benzin_main_footer')) :
    function benzin_main_footer()
    { ?>

        <!--====== FOOTER PART START ======-->

        <footer class="footer-area footer_style2">
            <div class="footer-widget pt-60 pb-60">

                <div class="container">
                    <div class="row">
                        <?php
                        if (is_active_sidebar('footer_menu')) {
                            dynamic_sidebar('footer_menu');
                        }
                        ?>


                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- footer widget -->
            <?php
            $benzin_footer_bottom_display = get_theme_mod('benzin_footer_bottom_display');
            if ('1' == $benzin_footer_bottom_display) : ?>
                <div class="footer-copyright pt-10 pb-20">
                    <div class="container">
                        <div class="copyright-section d-md-flex align-items-center justify-content-between">
                            <div class="copyright text-center pt-10">

                                <?php
                                $benzin_copyright_text = get_theme_mod('benzin_copyright_text');

                                ?>

                                <p class="pt-2 text">
                                    <?php if ($benzin_copyright_text) :
                                        echo esc_html($benzin_copyright_text); ?>
                                    <?php else : ?>
                                        &copy;
                                    <?php endif; ?>



                                    <?php
                                    echo date_i18n(
                                        /* translators: Copyright date format, see https://secure.php.net/date */
                                        _x('Y', 'copyright date format', 'benzin')
                                    );
                                    ?>
                                    <a href="<?php echo esc_url(__('https://wordpress.org/', 'benzin')); ?>">
                                        <?php
                                        /* translators: %s: CMS name, i.e. WordPress. */
                                        printf(esc_html__('Proudly powered by %s', 'benzin'), 'WordPress');
                                        ?>
                                    </a>
                                    <span class="sep"> | </span>
                                    <?php
                                    /* translators: 1: Theme name, 2: Theme author. */
                                    printf(esc_html__('Theme: %1$s by %2$s.', 'benzin'), 'benzin', '<a href="https://profiles.wordpress.org/nababurbd/">Nababur Rahaman</a>');
                                    ?>
                                </p>
                            </div> <!-- copyright -->
                            <div class="footer-bottom text-center pt-15">
                                <div class="social-icons">
                                    <?php

                                    $benzin_topbar_facebook = get_theme_mod('benzin_topbar_facebook');
                                    $benzin_topbar_instagram = get_theme_mod('benzin_topbar_instagram');
                                    $benzin_topbar_pinterest = get_theme_mod('benzin_topbar_pinterest');
                                    $benzin_topbar_twitter = get_theme_mod('benzin_topbar_twitter');
                                    ?>

                                    <ul>
                                        <?php if ($benzin_topbar_facebook) : ?>
                                            <li><a href="<?php echo esc_url($benzin_topbar_facebook); ?>"><i class="fab fa-facebook-f"></i></a></li>
                                        <?php endif; ?>
                                        <?php if ($benzin_topbar_instagram) : ?>
                                            <li><a href="<?php echo esc_url($benzin_topbar_instagram); ?>"><i class="fab fa-instagram"></i></a></li>
                                        <?php endif; ?>
                                        <?php if ($benzin_topbar_pinterest) : ?>
                                            <li><a href="<?php echo esc_url($benzin_topbar_pinterest); ?>"><i class="fab fa-pinterest-p"></i></a></li>
                                        <?php endif; ?>
                                        <?php if ($benzin_topbar_twitter) : ?>
                                            <li><a href="<?php echo esc_url($benzin_topbar_twitter); ?>"><i class="fab fa-twitter"></i></a></li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </div> <!-- payment -->
                        </div> <!-- copyright payment -->
                    </div> <!-- container -->
                </div> <!-- footer copyright -->

            <?php endif; ?>
        </footer>

        <!--====== FOOTER PART ENDS ======-->





        <?php
    }
endif;
add_action('benzin_action_footer', 'benzin_main_footer', 10);



/**
 * Post Slick Slider 
 * 
 * 
 */

if (!function_exists('benzin_blog_post_slider')) :

    function benzin_blog_post_slider()
    {


        $benzin_slider_display = get_theme_mod('benzin_slider_display');
        if ('1' == $benzin_slider_display) :


            $select_cat         = get_theme_mod('select_cat');
            $slider_blog_number = get_theme_mod('slider_blog_number');
            $order_by_setting   = get_theme_mod('order_by_setting');
            $order_setting      = get_theme_mod('order_setting');



        ?>

            <div id="home" class="header_hero header_style_2">
                <div class="container-fluid px-0">


                    <div class="slider-area home-slider">



                        <?php
                        $slides_cat = array(
                            'posts_per_page' => absint($slider_blog_number),
                            'category'       => $select_cat,
                            'post_status'    => 'publish',
                            'orderby'        => $order_by_setting,
                            'order'          => $order_setting,
                            'paged'          => 1,
                        );

                        if (absint($select_cat) > 0) {
                            $slides_cat['cat'] = absint($select_cat);
                        }
                        // Fetch posts.
                        $slider_query = new WP_Query($slides_cat);

                        ?>
                        <?php if ($slider_query->have_posts()) :
                            while ($slider_query->have_posts()) : $slider_query->the_post(); ?>

                                <div class="single-slider" style="background:#020306 url('<?php the_post_thumbnail_url('full'); ?>')">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="slider-content text-center">

                                                    <?php the_title('<h1 class="sub-title"  data-animation="fadeInDown" data-delay="0.3s"><a class="text-white" href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h1>'); ?>

                                                    <div class="text text-para" data-animation="fadeInUp" data-delay="0.7s"><?php echo benzin_get_excerpt(80); ?></div>

                                                    <div class="py-3" data-animation="fadeInUp" data-delay="0.9s">
                                                        <a class="btn m-auto  main-btn-blue mouse-hover" href="<?php the_permalink(); ?>"><?php esc_html_e('Free
                                                        Consultation', 'benzin'); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- row -->
                                    </div> <!-- container -->
                                </div> <!-- single slider -->

                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>

                    </div>

                </div> <!-- container -->
            </div> <!-- header hero -->


        <?php
        endif;
    }
endif;
add_action('benzin_hero_blog_slider_action', 'benzin_blog_post_slider', 10);


/**
 * Latest Post section
 * 
 * 
 */

if (!function_exists('benzin_latest_blog_posts')) :

    function benzin_latest_blog_posts()
    {
        $benzin_latestposts_display = get_theme_mod('benzin_latestposts_display');
        if ('1' == $benzin_latestposts_display) :


        ?>
            <?php
            $blog_section_title = get_theme_mod('benzin_latest_section_title');
            $blog_category      = get_theme_mod('benzin_latest_post_category');
            $blog_number        = get_theme_mod('benzin_latest_post_number');
            ?>
            <main id="site-content" class="site-main blog-post-area blog_style2 pt-80 pb-80">


                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-8">
                            <div class="section-title text-center">
                                <h3 class="title"><?php echo esc_html($blog_section_title); ?></h3>


                            </div> <!-- section title -->

                        </div>
                    </div> <!-- row -->
                    <div class="row">


                        <div class="col-lg-8">
                            <div class="row">

                                <?php
                                $blog_args = array(
                                    'posts_per_page' => absint($blog_number),
                                    'post_type'      => 'post',
                                    'post_status'    => 'publish',
                                    'paged'          => 1,
                                );

                                if (absint($blog_category) > 0) {
                                    $blog_args['cat'] = absint($blog_category);
                                }

                                // Fetch posts.
                                $blog_query = new WP_Query($blog_args);

                                ?>
                                <?php if ($blog_query->have_posts()) :
                                    while ($blog_query->have_posts()) : $blog_query->the_post(); ?>

                                        <!-- Blog Col -->
                                        <div class="col-md-6 <?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>" id=" post-<?php the_ID(); ?>">
                                            <div class="blog-card mt-10 mb-10">
                                                <div class="blog-image post-thumbnail lazy-load" <?php if ('post' === get_post_type()) : ?> <?php if (has_post_thumbnail()) : ?> style="background-image: url('<?php the_post_thumbnail_url('full'); ?>');" <?php else : ?> style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/no-thumb.png');" <?php endif; ?> <?php endif; ?>>
                                                    <div class="cap-cat">
                                                        <?php benzin_get_category(); ?>
                                                    </div>


                                                </div>
                                                <div class="post-meta py-3">

                                                    <ul class="list-unstyled">
                                                        <li style="margin-left: 0px;">
                                                            <?php benzin_posted_by(); ?></li>
                                                        <li><?php benzin_posted_on(); ?>
                                                        </li>
                                                    </ul>

                                                </div>
                                                <div class="blog-content">

                                                    <?php

                                                    the_title('<h5 class="entry-title blog-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>');

                                                    $benzin_blog_excerpt = get_theme_mod('benzin_blog_excerpt');
                                                    $benzin_blog_read_more = get_theme_mod('benzin_blog_read_more');

                                                    ?>
                                                    <?php if ($benzin_blog_excerpt) : ?>
                                                        <?php echo benzin_get_excerpt($benzin_blog_excerpt); ?>
                                                    <?php else : ?>
                                                        <?php echo benzin_get_excerpt(80); ?>
                                                    <?php endif; ?>


                                                    <?php if ($benzin_blog_read_more) : ?>
                                                        <a class="btn main-btn-blue mouse-hover" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($benzin_blog_read_more); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
                                                    <?php else : ?>
                                                        <a class="btn main-btn-blue mouse-hover" href="<?php echo esc_url(get_permalink()); ?>">
                                                            <?php esc_html_e('Read More', 'benzin'); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
                                                    <?php endif; ?>



                                                </div>
                                            </div> <!-- blog card -->
                                        </div>
                                        <!-- Blog Col -->
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                            <div class="row pt-30">
                                <div class="col-lg-12">
                                    <div class="blog_pagination pagination justify-content-center ">
                                        <?php

                                        if (function_exists('benzin_the_posts_pagination')) :
                                            benzin_the_posts_pagination();
                                        endif;

                                        ?>

                                    </div> <!-- section title -->

                                </div>
                            </div> <!-- row -->


                        </div>

                        <!-- Sidebar  -->
                        <div class="col-sm-12 blog-post-sidebar mt-10 col-md-12 col-lg-4">
                            <?php get_sidebar(); ?>
                        </div>



                    </div> <!-- row -->



                </div> <!-- container -->
            </main><!-- #main -->
        <?php
        endif;
    }
endif;
add_action('benzin_latest_blog_posts_action', 'benzin_latest_blog_posts', 10);



/**
 * Single page or post banner with title 
 * 
 * 
 */

if (!function_exists('benzin_blog_banner_header')) :
    /**
     * Page Header
     */
    function benzin_blog_banner_header()
    {
        if (is_front_page() && !is_home())
            return;
        $header_image = get_header_image();
        if (is_singular()) :
            $header_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_id(), 'full') : $header_image;
        endif;
        ?>
        <!-- #page-site-header -->
        <section class="breadcrumbs_section" style="background-image: url('<?php echo esc_url($header_image); ?>');">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-12">
                            <div class="breadcrumbs-content text-center">
                                <?php $pageBannerTitle  = benzin_blog_banner_title();
                                if ($pageBannerTitle) :
                                ?>
                                    <h1 class="page-title"><?php $pageBannerTitle ?></h1>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- #page-site-header -->
        <?php
    }
endif;
add_action('benzin_blog_banner_header', 'benzin_blog_banner_header', 10);

if (!function_exists('benzin_blog_banner_title')) :
    /**
     * Page Header
     */
    function benzin_blog_banner_title()
    {
        if ((is_front_page() && is_home()) || is_home()) {
            // $your_latest_posts_title = benzin_blog_get_option('your_latest_posts_title'); 
        ?>
            <?php

            $benzin_blog_title = get_theme_mod('benzin_blog_title');

            ?>
            <?php if ($benzin_blog_title) : ?>
                <h1 class="page-title"><?php echo esc_html($benzin_blog_title); ?></h1>
            <?php else : ?>
                <h1 class="page-title"><?php echo esc_html__('Blog', 'benzin')  ?></h1>
            <?php endif; ?>

        <?php
        }

        if (is_singular()) {
            the_title('<h1 class="page-title">', '</h1>');
        }

        if (is_archive()) {
            the_archive_title('<h1 class="page-title mb-2">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
        }

        if (is_search()) { ?>
            <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'benzin'), '<span>' . get_search_query() . '</span>'); ?></h1>
        <?php }

        if (is_404()) {
            echo '<h1 class="page-title">' . esc_html__('Error 404', 'benzin') . '</h1>';
        }
    }
endif;





// Author Box.
if (!function_exists('benzin_author')) :
    function benzin_author($id)
    {
        $id = $id ? $id : get_the_author_meta('ID');
        ?>
        <div class="row author-content">
            <div class="col-md-3">
                <?php echo get_avatar($id, '155', '', '', array('class' => 'lazy-load')); ?>
            </div>
            <div class="col-md-9">
                <h4 class="mb-2">
                    <a href="<?php echo esc_url(get_author_posts_url($id)); ?>"><?php echo esc_html(get_the_author_meta('display_name', $id)); ?></a>

                </h4>
                <p>
                    <?php the_author_meta('description', $id); ?>
                </p>
                <?php if (get_the_author_meta('url', $id) !== '') { ?>
                    <a href="<?php echo esc_url(get_the_author_meta('url', $id)); ?>" target="_blank"><i class="fa fa-link"></i></a>

                <?php } ?>
            </div>
        </div>
        <?php if (is_author()) : ?>
            <div class="clearfix"></div>
            <h5 class="mt-4">
                <?php esc_html__('Posts by', 'benzin') . esc_html(the_author_meta('display_name', $id)); ?>:

            </h5>
            <hr>
<?php
        endif;
    }
endif;
add_action('benzin_author', 'benzin_author', 3);
