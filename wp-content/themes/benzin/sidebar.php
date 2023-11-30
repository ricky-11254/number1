<?php

/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Benzin
 */

if (!is_active_sidebar('sidebar')) {
	return;
}
?>


<aside id="secondary" class="sidebar-widget">

	<?php dynamic_sidebar('sidebar'); ?>


</aside>