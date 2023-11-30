<?php

/**
 * This class handles Front Matter
 */
class Daextulma_Front_Matter {

	public function __construct( $shared ) {

		//assign an instance of the plugin info
		$this->shared = $shared;

	}

	/**
	 * Get the YAML data available in the provided string.
	 *
	 * @param $str
	 *
	 * @return array
	 */
	public function get($str){

		//Get an array with the Front Matter data by using the FrontYAML library
		require_once( $this->shared->get( 'dir' ) . 'globalize_front_yaml.php' );
		global $front_yaml_parser;

		try {
			$document = $front_yaml_parser->parse($str);
			$data = $document->getYAML();
		} catch (Exception $e) {
			$data = [];
		}

		//Sanitize and prepare the YAML data
		$data = $this->prepare_fields($data);

		return $data;

	}

	/**
	 * Sanitize and validate the data provided by the user as Front Matter fields.
	 *
	 * @param $yaml_data
	 *
	 * @return array
	 */
	private function prepare_fields($yaml_data){

		$sanitized_data = [];

		//Sanitization -------------------------------------------------------------------------------------------------

		//Title
		$sanitized_data['title'] = isset($yaml_data['title']) ? sanitize_text_field($yaml_data['title']) : null;

		//Excerpt
		$sanitized_data['excerpt'] = isset($yaml_data['excerpt']) ? sanitize_text_field($yaml_data['excerpt']) : null;

		//Categories
		$sanitized_data['categories'] = isset( $yaml_data['categories'] ) ? array_map( 'sanitize_text_field', $yaml_data['categories'] ) : null;

		//Tags
		$sanitized_data['tags'] = isset( $yaml_data['tags'] ) ? array_map( 'sanitize_text_field', $yaml_data['tags'] ) : null;

		//Author
		$sanitized_data['author'] = isset($yaml_data['author']) ? sanitize_text_field($yaml_data['author']) : null;

		//Date
		$sanitized_data['date'] = isset($yaml_data['date']) ? sanitize_text_field($yaml_data['date']) : null;

		//Status
		$sanitized_data['status'] = isset($yaml_data['status']) ? sanitize_key($yaml_data['status']) : null;

		//Validation ---------------------------------------------------------------------------------------------------

		$validated_data = [];

		//Title
		if(strlen(trim($sanitized_data['title'])) > 0){
			$validated_data['title'] = $sanitized_data['title'];
		}else{
			$validated_data['title'] = null;
		}

		//Excerpt
		if(strlen(trim($sanitized_data['excerpt'])) > 0){
			$validated_data['excerpt'] = $sanitized_data['excerpt'];
		}else{
			$validated_data['excerpt'] = null;
		}

		//Categories
		$validated_data['categories'] = $this->prepare_categories($sanitized_data['categories']);

		//Tags
		$validated_data['tags'] = $this->prepare_tags($sanitized_data['tags']);

		//Author
		$validated_data['author'] = $this->prepare_author($sanitized_data['author']);

		//Date
		$validated_data['date'] = $this->prepare_date($sanitized_data['date']);

		//status
		$validated_data['status'] = $this->prepare_status($sanitized_data['status']);

		return $validated_data;

	}
	
	/**
	 * Generates an array with existing category IDs from an array that includes:
	 *
	 * - Non verified category names
	 * - Non verified category IDs
	 *
	 * @param $raw_categories
	 *
	 * @return array An array with existing category IDs
	 */
	private function prepare_categories($raw_categories){

		if($raw_categories === null){
			return null;
		}

		$categories = [];
		foreach($raw_categories as $category){

			if(intval($category, 10)){

				//if a category with the provided ID exists use it
				if(term_exists($category, 'category')){
					$categories[] = $category;
				}

			}else{

				//Find the categories IDs from category name
				$found_category_id = get_cat_ID($category);
				if($found_category_id !== 0){
					$categories[] = $found_category_id;
				}

			}
		}

		if(count($categories) > 0){
			return $categories;
		}else{
			return null;
		}

	}

	/**
	 * Generates an array with existing category IDs from an array that includes:
	 *
	 * - Non verified category names
	 * - Non verified category IDs
	 *
	 * @param $raw_categories
	 *
	 * @return array An array with existing category IDs
	 */
	private function prepare_tags($raw_tags){

		if($raw_tags === null){
			return null;
		}

		$tags = [];
		foreach($raw_tags as $tag){

			if(intval($tag, 10)){

				//if a tag with the provided ID exists use it
				if(term_exists($tag, 'post_tag')){
					$tags[] = $tag;
				}

			}else{

				//Find the tags IDs from tag name
				$term_obj = get_term_by('name', $tag, 'post_tag');

				if($term_obj !== false){
					$tags[] = $term_obj->term_id;
				}

			}
		}

		if(count($tags) > 0){
			return $tags;
		}else{
			return null;
		}

	}

	/**
	 * If a valid user ID is provided returned the user ID. Otherwise retrieve the user from the user login name.
	 *
	 * @param $value
	 *
	 * @return int
	 */
	private function prepare_author($value){

		if($value === null){
			return null;
		}

		//If the user is provided with a valid ID return its ID
		if($this->shared->user_id_exists($value)){

			return $value;

		}else{

			//Get the ID of the user from the user login name.
			$user_obj = get_user_by('login', $value);

			if($user_obj !== false){

				return $user_obj->ID;

			}

		}

		return null;

	}


	/**
	 * If the date is valid returns it, otherwise returns null.
	 * 
	 * @param $date
	 *
	 * @return string|null
	 */
	private function prepare_date($date){

		if($date === null){
			return null;
		}

		/**
		 * Note that the FrontYaml convert the date available in the string in the 'Y-m-d h:i:s' format to a unix date.
		 * As a consequence the date here is reconverted to the 'Y-m-d h:i:s' format with the PHP date() function.
		 */
		$date = date('Y-m-d h:i:s', $date);

		//Validate the date with a regex
		$date_regex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-6][0-9]|[0-9]):([0-6][0-9]|[0-9]):([0-6][0-9]|[0-9])$/";
		if (preg_match($date_regex, $date)) {
			$date = $date;
		}else{
			$date = null;
		}

		return $date;

	}

	/**
	 * If the provided status is valid returns the status, otherwise returns false.
	 *
	 * Note that only six of the height default WordPress statuses are valid.
	 * See: https://wordpress.org/support/article/post-status/
	 *
	 * @param $status
	 *
	 * @return mixed|null
	 */
	private function prepare_status($status) {

		$valid_statuses = ['publish', 'future', 'draft', 'pending', 'private', 'trash'];
		if ( in_array( $status, $valid_statuses) ){
			return $status;
		}else{
			return null;
		}

	}

}