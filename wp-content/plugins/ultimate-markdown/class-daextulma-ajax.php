<?php

/*
 * This class should be used to include ajax actions.
 */

class Daextulma_Ajax {

	protected static $instance = null;
	private $shared = null;

	private function __construct() {

		//Assign an instance of the plugin info
		$this->shared = Daextulma_Shared::get_instance();

		//Ajax requests for logged-in users ----------------------------------------------------------------------------
		add_action( 'wp_ajax_daextulma_import_document', array( $this, 'daextulma_import_document' ) );
		add_action( 'wp_ajax_daextulma_load_document', array( $this, 'daextulma_load_document' ) );
		add_action( 'wp_ajax_daextulma_submit_markdown', array( $this, 'daextulma_submit_markdown' ) );

		//Require and instantiate the class used to handle Front Matter
		require_once( $this->shared->get( 'dir' ) . 'admin/inc/class-daextulmap-front-matter.php' );
		$this->front_matter = new Daextulma_Front_Matter( $this->shared );

	}

	/*
	 * Return an instance of this class
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	/*
	* Ajax handler used to retrieve the title and the content of the uploaded markdown file.
	*
	* This method is called when the "Import" button available in the post editor sidebar is clicked and then a markdown
	 * file is selected.
	*/
	public function daextulma_import_document() {

		//check the referer
		if ( ! check_ajax_referer( 'daextulma', 'security', false ) ) {
			echo esc_html__( 'Invalid AJAX Request', 'ultimate-markdown' );
			die();
		}

		//check the capability
		if ( ! current_user_can( 'edit_posts' ) ) {
			echo esc_html__( 'Invalid Capability', 'ultimate-markdown' );
			die();
		}

		if ( isset( $_FILES['uploaded_file'] ) ) {

			//Sanitize the uploaded file
			$file_data = $this->shared->sanitize_uploaded_file( $_FILES['uploaded_file'] );

			//Get the file content
			$document = $this->shared->get_markdown_file_content( $file_data );

			//Get the Front Matter data
			$front_matter = $this->front_matter->get($document);

			//if the title is set with the YAML data use it. Otherwise obtain the title from the file name.
			$title = isset( $front_matter['title'] ) ?
				$front_matter['title'] :
				sanitize_text_field( $this->shared->get_title_from_file_name( $file_data['name'] ) );

			//Echo the JSON data associated with the Markdown document
			echo $this->shared->generate_markdown_document_json($title, $document, $front_matter);

		}

		die();

	}

	/*
	* Ajax handler used to return the title and the content of the submitted document id.
	*
	* This method is called when the user selects a document with the selector available in the "Load Document"
	* component available in the post sidebar of the editor.
	*/
	public function daextulma_load_document() {

		//check the referer
		if ( ! check_ajax_referer( 'daextulma', 'security', false ) ) {
			echo esc_html__( 'Invalid AJAX Request', 'ultimate-markdown' );
			die();
		}

		//check the capability
		if ( ! current_user_can( 'edit_posts' ) ) {
			echo esc_html__( 'Invalid Capability', 'ultimate-markdown' );
			die();
		}

		$document_id = isset( $_POST['document_id'] ) ? intval( $_POST['document_id'], 10 ) : 0;

		//Get the document object
		global $wpdb;
		$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
		$safe_sql     = $wpdb->prepare( "SELECT * FROM $table_name WHERE document_id = %d ", $document_id );
		$document_obj = $wpdb->get_row( $safe_sql );

		if ( $document_obj !== false ) {

			//Get the Front Matter data
			$front_matter = $this->front_matter->get(stripslashes($document_obj->content));

			//if the title is set with Front Matter use it. Otherwise use the file name as title
			$title = isset($front_matter['title']) ? $front_matter['title'] : $document_obj->title;

			//Echo the JSON data associated with the Markdown document
			echo $this->shared->generate_markdown_document_json($title, $document_obj->content, $front_matter);

		} else {

			die();

		}

		die();

	}

	/*
	* Ajax handler used to return the title and the content of the submitted document.
	*
	* This method is called when the user clicks the "Submit Text" button of the "Load Document" sidebar section
	 * available in the post sidebar of the editor.
	*/
	public function daextulma_submit_markdown() {

		//check the referer
		if ( ! check_ajax_referer( 'daextulma', 'security', false ) ) {
			echo esc_html__( 'Invalid AJAX Request', 'ultimate-markdown' );
			die();
		}

		//check the capability
		if ( ! current_user_can( 'edit_posts' ) ) {
			echo esc_html__( 'Invalid Capability', 'ultimate-markdown' );
			die();
		}

		$content = isset( $_POST['markdowntext'] ) ? sanitize_textarea_field( stripslashes($_POST['markdowntext']) ) : '';

		//Get the Front Matter data
		$front_matter = $this->front_matter->get($content);

		//if the title is set with Front Matter use it. Otherwise use the file name as title.
		$title = isset($front_matter['title']) ? $front_matter['title'] : null;

		//Echo the JSON data associated with the Markdown document
		echo $this->shared->generate_markdown_document_json($title, $content, $front_matter);

		die();

	}

}