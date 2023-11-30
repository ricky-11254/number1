<?php

/**
 * Header of benzin theme
 * @package benzin
 * @subpackage benzin
 * @since benzin 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	} else {
		do_action('wp_body_open');
	}
	?>
	<?php
	/**
	 * Hook - benzin_action_header
	 *
	 * @hooked benzin_main_header - 10
	 */
	do_action('benzin_action_header');
	?>

	<?php

	/**
	 * Banner start
	 * 
	 * @hooked benzin_blog_banner_header - 10
	 */
	do_action('benzin_blog_banner_header');
