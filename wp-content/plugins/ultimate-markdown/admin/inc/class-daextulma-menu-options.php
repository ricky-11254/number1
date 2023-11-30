<?php

/**
 * This class adds the options with the related callbacks and validations.
 */
class Daextulma_Menu_Options {

	private $shared = null;

	public function __construct( $shared ) {

		//assign an instance of the plugin info
		$this->shared = $shared;

	}

	public function register_options() {

		//Section General ----------------------------------------------------------------------------------------------
		add_settings_section(
			'daextulma_general_settings_section',
			null,
			null,
			'daextulma_general_options'
		);

		add_settings_field(
			'documents_menu_required_capability',
			esc_html__( 'Documents Menu Capability', 'ultimate-markdown' ),
			array( $this, 'documents_menu_required_capability_callback' ),
			'daextulma_general_options',
			'daextulma_general_settings_section'
		);

		register_setting(
			'daextulma_general_options',
			'daextulma_documents_menu_required_capability',
			array( $this, 'documents_menu_required_capability_validation' )
		);

		add_settings_field(
			'import_menu_required_capability',
			esc_html__( 'Import Menu Capability', 'ultimate-markdown' ),
			array( $this, 'import_menu_required_capability_callback' ),
			'daextulma_general_options',
			'daextulma_general_settings_section'
		);

		register_setting(
			'daextulma_general_options',
			'daextulma_import_menu_required_capability',
			array( $this, 'import_menu_required_capability_validation' )
		);

		add_settings_field(
			'export_menu_required_capability',
			esc_html__( 'Export Menu Capability', 'ultimate-markdown' ),
			array( $this, 'export_menu_required_capability_callback' ),
			'daextulma_general_options',
			'daextulma_general_settings_section'
		);

		register_setting(
			'daextulma_general_options',
			'daextulma_export_menu_required_capability',
			array( $this, 'export_menu_required_capability_validation' )
		);

	}

	//import options callbacks and validations -----------------------------------------------------------------------------
	public function documents_menu_required_capability_validation( $input ) {

		return sanitize_key( $input );

	}

	public function documents_menu_required_capability_callback( $args ) {

		$html = '<input type="text" id="daextulma-documents-menu-required-capability" name="daextulma_documents_menu_required_capability" class="regular-text" value="' . esc_attr( get_option( "daextulma_documents_menu_required_capability" ) ) . '" />';
		$html .= '<div class="help-icon" title="' . esc_attr__( 'The capability required to get access on the "Documents" menu.', 'ultimate-markdown' ) . '"></div>';

		echo $html;

	}

	public function import_menu_required_capability_validation( $input ) {

		return sanitize_key( $input );

	}

	public function import_menu_required_capability_callback( $args ) {

		$html = '<input type="text" id="daextulma-import-menu-required-capability" name="daextulma_import_menu_required_capability" class="regular-text" value="' . esc_attr( get_option( "daextulma_import_menu_required_capability" ) ) . '" />';
		$html .= '<div class="help-icon" title="' . esc_attr__( 'The capability required to get access on the "Import" menu.', 'ultimate-markdown' ) . '"></div>';

		echo $html;

	}

	public function export_menu_required_capability_validation( $input ) {

		return sanitize_key( $input );

	}

	public function export_menu_required_capability_callback( $args ) {

		$html = '<input type="text" id="daextulma-export-menu-required-capability" name="daextulma_export_menu_required_capability" class="regular-text" value="' . esc_attr( get_option( "daextulma_export_menu_required_capability" ) ) . '" />';
		$html .= '<div class="help-icon" title="' . esc_attr__( 'The capability required to get access on the "Export" menu.', 'ultimate-markdown' ) . '"></div>';

		echo $html;

	}

}