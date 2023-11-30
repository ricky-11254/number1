<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Benzin
 */

get_header();
?>

<main id="site-content" class="site-main error-area pt-80 pb-80">
	<div class="container">


		<div class="row  align-items-center justify-content-center">
			<div class="error-content text-center">
				<h2><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'benzin'); ?> </h2>
				<span><?php esc_html_e('Page not Found', 'benzin'); ?></span>
				<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'benzin'); ?></p>

			</div>
			<div class="back_btn text-center">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="btn my-4 main-btn-blue mouse-hover"> <span></span><?php esc_html_e('Back To Home', 'benzin'); ?> <i class="fal fa-long-arrow-right"></i></a>
			</div>


		</div> <!-- row -->



	</div> <!-- container -->
</main><!-- #main -->

<?php
get_footer();
