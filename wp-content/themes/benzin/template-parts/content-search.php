<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benzin
 */

?>

<!-- Blog Col -->
<article class="col-lg-4 col-md-6" id="post-<?php the_ID(); ?>">
	<div class="blog-card mt-10 mb-10">
		<div class="blog-image post-thumbnail lazy-load" <?php if ('post' === get_post_type()) : ?> <?php if (has_post_thumbnail()) : ?> style="background-image: url('<?php the_post_thumbnail_url('full'); ?>');" <?php

																																																				else : ?> style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/images/no-thumb.png');" <?php
																																																																																	endif;
																																																																																		?> <?php endif; ?>>
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
			?>

			<?php echo benzin_get_excerpt(80); ?>
			<a class="btn main-btn-blue mouse-hover" href="<?php the_permalink(); ?>"><?php echo __('Read
                More', 'benzin'); ?><span></span><i class="fal fa-long-arrow-right"></i></a>
		</div>
	</div> <!-- blog card -->
</article>
<!-- Blog Col -->