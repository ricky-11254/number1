<?php

/*
 * this class should be used to stores properties and methods shared by the
 * admin and public side of wordpress
 */

class Daextulma_Shared {

	protected static $instance = null;

	private $data = array();

	private function __construct() {

		$this->data['slug'] = 'daextulma';
		$this->data['ver']  = '1.12';
		$this->data['dir']  = substr( plugin_dir_path( __FILE__ ), 0, - 7 );
		$this->data['url']  = substr( plugin_dir_url( __FILE__ ), 0, - 7 );

		//Here are stored the plugin option with the related default values
		$this->data['options'] = [

			//Database Version -----------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_database_version'                   => "0",

			//General --------------------------------------------------------------------------------------------------
			$this->get( 'slug' ) . '_documents_menu_required_capability' => "edit_posts",
			$this->get( 'slug' ) . '_import_menu_required_capability'    => "edit_posts",
			$this->get( 'slug' ) . '_export_menu_required_capability'    => "edit_posts",

		];

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	//retrieve data
	public function get( $index ) {
		return $this->data[ $index ];
	}

	/*
	 * Given an array with the information related to the uploaded Markdown file
	 * (markdown|mdown|mkdn|md|mkd|mdwn|mdtxt|mdtext|text|txt) the content of the markdown file is returned.
	 *
	 * @param $file_info An array with the information related to the uploaded file.
	 */
	public function get_markdown_file_content( $file_info ) {

		$file_name = $file_info['name'];

		//verify the extension
		if ( preg_match( '/^.+\.(markdown|mdown|mkdn|md|mkd|mdwn|mdtxt|mdtext|text|txt)$/', $file_name, $matches ) === 1 ) {

			//get the file content
			$file_content = file_get_contents( $file_info['tmp_name'] );

			return $file_content;

		} else {

			return false;

		}

	}

	/*
	 * Returns the number of records available in the '[prefix]_daextulma_document' db table
	 *
	 * @return int The number of records available in the '[prefix]_daextulma_document' db table
	 */
	public function number_of_documents() {

		global $wpdb;
		$table_name  = $wpdb->prefix . $this->get( 'slug' ) . "_document";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

		return intval( $total_items, 10 );

	}

	/**
	 * Sanitize the data of an uploaded file.
	 *
	 * @param $file
	 *
	 * @return array
	 */
	function sanitize_uploaded_file( $file ) {

		return [
			'name'     => sanitize_text_field( $file['name'] ),
			'type'     => $file['tmp_name'],
			'tmp_name' => $file['tmp_name'],
			'error'    => intval( $file['error'], 10 ),
			'size'     => intval( $file['size'], 10 )
		];

	}

	/**
	 * If multiple documents have the same name rename the documents with the duplicate name. This is
	 * necessary to ovoid overwriting files with the same names.
	 *
	 * @param $document_a The array with the documents.
	 *
	 * @return mixed The array with the documents with the duplicate names renamed.
	 */
	public function rename_duplicate_names_in_document( $document_a ) {


		foreach ( $document_a as $key1 => $document ) {

			//This is the suffix added at the end of the file name when duplicates are present
			$counter = 1;

			do {

				$document_copy_a = $document_a;
				$matches         = 0;
				$copy_key        = null;

				/**
				 * Check if $document['title'] exists more than one time in the array. If it existing more than
				 * one time get the key of last occurence where it exists.
				 */
				foreach ( $document_copy_a as $key2 => $document_copy ) {
					if ( $document['title'] === $document_copy['title'] ) {
						$copy_key = $key2;
						$matches ++;
					}
				}

				/**
				 * Use the key of the duplicate name found in the last step to modify the document title of the
				 * duplicate. This step is performed only if more that one match is found. If there is only one
				 * match this means that there are no duplicates.
				 */
				if ( $matches > 1 ) {
					$document_a[ $copy_key ]['title'] .= $counter;
					$counter ++;
				}

			} while ( $matches > 1 );

		}

		return $document_a;

	}

	/*
	 * Get the document/post title from the file name.
	 *
	 * @param $filename
	 * @return The title of the document/post.
	 */
	public function get_title_from_file_name( $filename ) {

		//Remove the markdown extension from the filename.
		preg_match( '/.*\.(markdown|mdown|mkdn|md|mkd|mdwn|mdtxt|mdtext|text|txt)$/', $filename, $matches,
			PREG_OFFSET_CAPTURE );
		$title = substr( $filename, 0, $matches[1][1] - 1 );

		return $title;

	}

	/**
	 * Whether a user with this user ID exists.
	 *
	 * @param $user
	 *
	 * @return bool
	 */
	function user_id_exists( $user ) {

		global $wpdb;

		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user ) );

		if ( $count == 1 ) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Generates the JSON data associated with a Markdown document.
	 *
	 * @param $title
	 * @param $document
	 */
	function generate_markdown_document_json($title, $document, $front_matter){

		//Remove the YAML part from the document
		$markdown_data = $this->remove_yaml($document);

		//return the HTML generated from the markdown file
		return json_encode( [
			'content' => $markdown_data,
			'title' => $title,
			'excerpt' => $front_matter['excerpt'],
			'categories' => $front_matter['categories'],
			'tags' => $front_matter['tags'],
			'author' => $front_matter['author'],
			'date' => $front_matter['date'],
			'status' => $front_matter['status']
		] );

	}

	/**
	 * Removes the YAML content from the provided strings. Note that only YAML content placed at the beginning of the
	 * string is removed. This is where Frontmatter is added.
	 *
	 * @param $str
	 *
	 * @return array|string|string[]|null
	 */
	public function remove_yaml($str){

		return preg_replace('/^\s*-{3}\R.+?\R-{3}/ms', '', $str);

	}

}