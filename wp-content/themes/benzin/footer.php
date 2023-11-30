<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Benzin
 */

?>

<?php
/**
 * Hook - benzin_action_footer
 * @hooked benzin_main_footer - 10
 */
do_action('benzin_action_footer');
?>
<!--====== BACK TOP TOP PART START ======-->

<a href="#" class="back-to-top back-blue"><i class="fal fa-angle-double-up"></i></a>

<!--====== BACK TOP TOP PART ENDS ======-->
<?php wp_footer(); ?>

</body>

</html>