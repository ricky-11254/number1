<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Benzin
 */

get_header();
?>

<main id="site-content" class="site-main single-post-details pt-80 pb-80">
	<div class="container">

		<div class="row">


			<div class="col-lg-8">
				<div class="blog-details-wrap mt-10">
					<div class="details__content  pb-30">
						<?php
						while (have_posts()) :
							the_post();

							get_template_part('template-parts/content', get_post_type()); ?>

							<div class="posts_navigation pt-35 pb-10">
								<?php if (is_singular('post')) {
									// Previous/next post navigation.
									the_post_navigation(
										array(
											'prev_text' => '<span class="nav-subtitle prev-link">' . esc_html__('Previous post:', 'benzin') . '</span> <span class="nav-title">%title</span>',
											'next_text' => '<span class="nav-subtitle next-link">' . esc_html__('Next post:', 'benzin') . '</span> <span class="nav-title">%title</span>',
										)
									);
								}
								?>
							</div>


							<section class="authorpage mt-4 mb-4">
								<?php do_action('benzin_author'); ?>
							</section>
							<div class="comment__wrap">
							<?php // If comments are open or we have at least one comment, load up the comment template.
							if (comments_open() || get_comments_number()) :
								comments_template();
							endif;

						endwhile; // End of the loop.
							?>
							</div>
					</div>
				</div>
			</div>

			<!-- Sidebar  -->
			<div class="col-sm-12 blog-post-sidebar mt-10 col-md-12 col-lg-4">
				<?php get_sidebar(); ?>
			</div>



		</div> <!-- row -->


	</div> <!-- container -->
</main><!-- #main -->

<?php

get_footer();
