<?php

//Prevent direct access to this file
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Enqueue the Gutenberg block assets for the backend.
 *
 * 'wp-blocks': includes block type registration and related functions.
 * 'wp-element': includes the WordPress Element abstraction for describing the structure of your blocks.
 */
function daextulma_editor_assets() {

	//Scripts ----------------------------------------------------------------------------------------------------------

	//Block
	wp_enqueue_script(
		'daextulma-editor-js', // Handle.
		plugins_url( '/build/index.js', dirname( __FILE__ ) ), //We register the block here.
		array( 'wp-blocks', 'wp-element' ), // Dependencies.
		false,
		true //Enqueue the script in the footer.
	);

}

/**
 * Do not enable the editor assets if we are in one of the following menus:
 *
 * - Appearance -> Widgets (widgets.php).
 * - Appearance -> Editor (site-editor.php)
 *
 * Enabling the assets in the widgets.php or site-editor.php menus would cause errors because the post editor sidebar is
 * not available in these menus.
 */
global $pagenow;
if ( $pagenow !== 'widgets.php' and
     $pagenow !== 'site-editor.php' ) {
	add_action( 'enqueue_block_editor_assets', 'daextulma_editor_assets' );
}

/**
 * Register the meta fields used in the components of the post sidebar.
 *
 * See: https://developer.wordpress.org/reference/functions/register_post_meta/
 */
function ultimate_markdown_register_post_meta() {

	/*
	 * Register the meta used to save the value of the selector available in the "Load Document" section of the post
	 * sidebar included in the post editor.
	 */
	register_post_meta(
		'', //Registered in all post types
		'_import_markdown_pro_load_document_selector',
		[
			'auth_callback' => '__return_true',
			'default'       => 0,
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'integer',
		]
	);

	/*
	 * Register the meta used to save the value of the textarea available in the "Submit Text" section of the post
	 * sidebar included in the post editor.
	 */
	register_post_meta(
		'', //Registered in all post types
		'_import_markdown_pro_submit_text_textarea',
		[
			'auth_callback' => '__return_true',
			'default'       => '',
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
		]
	);

}

add_action( 'init', 'ultimate_markdown_register_post_meta' );