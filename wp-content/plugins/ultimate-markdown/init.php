<?php
/*
Plugin Name: Ultimate Markdown
Description: Create WordPress posts with the popular Markdown syntax.
Version: 1.12
Author: DAEXT
Author URI: https://daext.com
*/

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) {
	die();
}

//Class shared across public and admin
require_once( plugin_dir_path( __FILE__ ) . 'shared/class-daextulma-shared.php' );

//Perform the Gutenberg related activities only if Gutenberg is present
if ( function_exists( 'register_block_type' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'blocks/src/init.php' );
}

//Admin
if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	//Admin
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-daextulma-admin.php' );
	add_action( 'plugins_loaded', array( 'Daextulma_Admin', 'get_instance' ) );

	//Activate
	register_activation_hook( __FILE__, array( Daextulma_Admin::get_instance(), 'ac_activate' ) );

}

//Ajax
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

	//Admin
	require_once( plugin_dir_path( __FILE__ ) . 'class-daextulma-ajax.php' );
	add_action( 'plugins_loaded', array( 'daextulma_Ajax', 'get_instance' ) );

}

//Customize the action links in the "Plugins" menu
function daextulma_customize_action_links( $actions ) {
	$actions[] = '<a href="https://daext.com/ultimate-markdown/">' . esc_html__('Buy the Pro Version', 'ultimate-markdown') . '</a>';
	return $actions;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'daextulma_customize_action_links' );