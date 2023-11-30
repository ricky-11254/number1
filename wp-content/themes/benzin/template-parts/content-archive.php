<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package benzin
 */
?>

<!-- Blog Col -->
<div class="col-md-6" id="post-<?php the_ID(); ?>">
    <div class="blog-card mt-10 mb-10">
        <div class="blog-image post-thumbnail lazy-load" <?php if ('post' === get_post_type()) : ?> <?php if (has_post_thumbnail()) : ?> style="background-image: url('<?php echo esc_url(the_post_thumbnail_url('full')); ?>');" <?php else : ?> style="background-image: url('<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/no-thumb.png');" <?php endif; ?> <?php endif; ?>>
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
            if (is_singular()) :
                the_title('<h5 class="entry-title blog-title">', '</h5>');
            else :
                the_title('<h5 class="entry-title blog-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>');
            endif;

            $benzin_blog_excerpt = get_theme_mod('benzin_blog_excerpt');
            $benzin_blog_read_more = get_theme_mod('benzin_blog_read_more');

            ?>
            <?php if ($benzin_blog_excerpt) : ?>
                <?php echo benzin_get_excerpt($benzin_blog_excerpt); ?>
            <?php else : ?>
                <?php echo benzin_get_excerpt(80); ?>
            <?php endif; ?>


            <?php if ($benzin_blog_read_more) : ?>
                <a class="btn main-btn-blue mouse-hover" href="<?php the_permalink(); ?>"><?php echo esc_html($benzin_blog_read_more); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
            <?php else : ?>
                <a class="btn main-btn-blue mouse-hover" href="<?php the_permalink(); ?>"><?php esc_html_e('Read
More', 'benzin'); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
            <?php endif; ?>
        </div>
    </div> <!-- blog card -->
</div>
<!-- Blog Col -->