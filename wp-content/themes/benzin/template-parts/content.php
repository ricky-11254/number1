<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benzin
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">


		<?php if ('post' === get_post_type()) :
		?>
			<div class="meta-info">
				<ul>
					<li><?php benzin_posted_by(); ?></li>
					<li><?php benzin_posted_on(); ?> </li>
					<li><i class="fal fa-tags mx-2 ml-0"></i><?php


																benzin_get_category();
																?></li>
				</ul>
			</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content mb-4 mt-4">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'benzin'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			)
		);


		?>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->