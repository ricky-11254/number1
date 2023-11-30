<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Benzin
 */

get_header();
?>

<main id="site-content" class="site-main blog-post-area blog_style2 pt-80 pb-80">
	<div class="container">

		<div class="row">

			<div class="col-lg-8">
				<div class="row">

					<?php
					if (have_posts()) :


					?>

					<?php


						/* Start the Loop */

						while (have_posts()) :
							the_post();


							/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */

							get_template_part('template-parts/content', 'archive');


						endwhile;



					else :

						get_template_part('template-parts/content', 'none');

					endif;
					?>

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

get_footer();
