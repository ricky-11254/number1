<?php

/*
 * this class should be used to work with the administrative side of wordpress
 */

class Daextulma_Admin {

	protected static $instance = null;
	private $shared = null;

	private $screen_id_documents = null;
	private $screen_id_import = null;
	private $screen_id_export = null;
	private $screen_id_help = null;
	private $screen_id_pro_version = null;
	private $screen_id_options = null;
	private $menu_options = null;

	private function __construct() {

		//assign an instance of the plugin info
		$this->shared = Daextulma_Shared::get_instance();

		//Load admin stylesheets and JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		//Add the admin menu
		add_action( 'admin_menu', array( $this, 'me_add_admin_menu' ) );

		//this hook is triggered during the creation of a new blog
		add_action( 'wpmu_new_blog', array( $this, 'new_blog_create_options_and_tables' ), 10, 6 );

		//this hook is triggered during the deletion of a blog
		add_action( 'delete_blog', array( $this, 'delete_blog_delete_options_and_tables' ), 10, 1 );

		//Export controller
		add_action( 'init', array( $this, 'export_controller' ) );

		//Require and instantiate the class used to register the menu options
		require_once( $this->shared->get( 'dir' ) . 'admin/inc/class-daextulma-menu-options.php' );
		$this->menu_options = new Daextulma_Menu_Options( $this->shared );

		//Load the options API registrations and callbacks
		add_action( 'admin_init', array( $this, 'op_register_options' ) );

        //Register the support of the 'custom-fields' to all the post type with UI
        add_action('init', array($this, 'register_support_on_post_types'), 100);

	}

	/*
	 * return an instance of this class
	 */
	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

    /**
     * Register the support of the 'custom-fields' to all the post type with UI.
     *
     * The 'custom-fields' support is required by the sidebar components that use meta data. Without the
     * 'custom-fields' support associated with the posts, the following meta data can't be used by the sidebar
     * components and a JavaScript error breaks the editor.
     *
     * - _import_markdown_pro_load_document_selector
     * - _import_markdown_pro_submit_text_textarea
     *
     * See: https://developer.wordpress.org/reference/functions/add_post_type_support/
     */
    public function register_support_on_post_types()
    {
        //Get the post types with UI
        $available_post_types_a = get_post_types(array(
            'show_ui' => true
        ));

        //Remove the 'attachment' post type
        $available_post_types_a = array_diff($available_post_types_a, array('attachment'));

        //Add the 'custom-fields' support to the post types with UI
        foreach ($available_post_types_a as $available_post_type) {
            add_post_type_support($available_post_type, 'custom-fields');
        }

    }

	public function enqueue_admin_styles() {

		$screen = get_current_screen();

		//menu documents
		if ( $screen->id == $this->screen_id_documents ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-menu',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/menu.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-documents',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-documents.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//jQuery UI Dialog
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-dialog-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
				$this->shared->get( 'ver' ) );

			//Select2
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/select2-custom.css', array(),
				$this->shared->get( 'ver' ) );

		}

		//Menu Help
		if ( $screen->id == $this->screen_id_help ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-help',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-help.css', array(), $this->shared->get( 'ver' ) );

		}

		//Menu Pro Version
		if ( $screen->id == $this->screen_id_pro_version ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-menu-pro-version',
				$this->shared->get( 'url' ) . 'admin/assets/css/menu-pro-version.css', array(), $this->shared->get( 'ver' ) );

		}

		//menu options
		if ( $screen->id == $this->screen_id_options ) {

			wp_enqueue_style( $this->shared->get( 'slug' ) . '-framework-options',
				$this->shared->get( 'url' ) . 'admin/assets/css/framework/options.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip',
				$this->shared->get( 'url' ) . 'admin/assets/css/jquery-ui-tooltip.css', array(),
				$this->shared->get( 'ver' ) );

			//Select2
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/css/select2.min.css', array(),
				$this->shared->get( 'ver' ) );
			wp_enqueue_style( $this->shared->get( 'slug' ) . '-select2-custom',
				$this->shared->get( 'url' ) . 'admin/assets/css/select2-custom.css', array(),
				$this->shared->get( 'ver' ) );

		}

	}

	/*
	 * enqueue admin-specific javascript
	 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();

		//menu documents
		if ( $screen->id == $this->screen_id_documents ) {

			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', array( 'jquery' ),
				$this->shared->get( 'ver' ) );

			//Select2
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-select2',
				$this->shared->get( 'url' ) . 'admin/assets/inc/select2/js/select2.min.js', 'jquery',
				$this->shared->get( 'ver' ) );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-marked',
				$this->shared->get( 'url' ) . 'admin/assets/inc/marked/marked.min.js', array(),
				$this->shared->get( 'ver' ) );

			//DOMPurify
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-dompurify',
				$this->shared->get( 'url' ) . 'admin/assets/inc/DOMPurify/dist/purify.min.js', 'jquery',
				$this->shared->get( 'ver' ) );

			wp_enqueue_script( $this->shared->get( 'slug' ) . '-menu-documents',
				$this->shared->get( 'url' ) . 'admin/assets/js/menu-documents.js', array(
					'jquery',
					'jquery-ui-dialog',
					$this->shared->get( 'slug' ) . '-select2',
					$this->shared->get( 'slug' ) . '-marked',
					$this->shared->get( 'slug' ) . '-dompurify'
				),
				$this->shared->get( 'ver' ) );
			$wp_localize_script_data = array(
				'deleteText' => strip_tags( __( 'Delete', 'ultimate-markdown' ) ),
				'cancelText' => strip_tags( __( 'Cancel', 'ultimate-markdown' ) ),
			);
			wp_localize_script( $this->shared->get( 'slug' ) . '-menu-documents', 'objectL10n',
				$wp_localize_script_data );

		}

		//menu options
		if ( $screen->id == $this->screen_id_options ) {

			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-jquery-ui-tooltip-init',
				$this->shared->get( 'url' ) . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
				$this->shared->get( 'ver' ) );

		}

		//Load the assets for the post editor
		$available_post_types_a = get_post_types( array(
			'show_ui' => true
		) );

		//Remove the "attachment" post type
		$available_post_types_a = array_diff( $available_post_types_a, array( 'attachment' ) );
		if ( in_array( $screen->id, $available_post_types_a ) ) {

			/**
			 * When the editor file is loaded (only in the post editor) add the names and IDs of all the documents as
			 * json data in a property of the window.DAEXTULMA_PARAMETERS object.
			 *
			 * These data are used to populate the "Select Document" selector available in the post sidebar.
			 */
			global $wpdb;
			$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
			$sql        = "SELECT document_id, title FROM $table_name ORDER BY document_id DESC";
			$document_a = $wpdb->get_results( $sql, ARRAY_A );

			$document_a_alt   = [];
			$document_a_alt[] = [
				'value' => 0,
				'label' => __( 'Not set', 'ultimate-markdown' ),
			];
			foreach ( $document_a as $key => $value ) {
				$document_a_alt[] = [
					'value' => intval( $value['document_id'], 10 ),
					'label' => stripslashes( $value['title'] ),
				];
			}

			//Store the JavaScript parameters in the window.DAEXTULMA_PARAMETERS object
			$initialization_script = 'window.DAEXTULMA_PARAMETERS = {';
			$initialization_script .= "documents: " . json_encode( $document_a_alt ) . ',';
			$initialization_script .= 'ajaxUrl: "' . admin_url( 'admin-ajax.php' ) . '",';
			$initialization_script .= 'nonce: "' . wp_create_nonce( "daextulma" ) . '",';
			$initialization_script .= '};';
			wp_add_inline_script( $this->shared->get( 'slug' ) . '-editor-js', $initialization_script, 'before' );

			//Marked
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-marked',
				$this->shared->get( 'url' ) . 'admin/assets/inc/marked/marked.min.js', array(),
				$this->shared->get( 'ver' ) );

			//DOMPurify
			wp_enqueue_script( $this->shared->get( 'slug' ) . '-dompurify',
				$this->shared->get( 'url' ) . 'admin/assets/inc/DOMPurify/dist/purify.min.js', 'jquery',
				$this->shared->get( 'ver' ) );

		}

	}

	/*
	 * plugin activation
	 */
	public function ac_activate( $networkwide ) {

		/*
		 * delete options and tables for all the sites in the network
		 */
		if ( function_exists( 'is_multisite' ) and is_multisite() ) {

			/*
			 * if this is a "Network Activation" create the options and tables
			 * for each blog
			 */
			if ( $networkwide ) {

				//get the current blog id
				global $wpdb;
				$current_blog = $wpdb->blogid;

				//create an array with all the blog ids
				$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

				//iterate through all the blogs
				foreach ( $blogids as $blog_id ) {

					//swith to the iterated blog
					switch_to_blog( $blog_id );

					//create options and tables for the iterated blog
					$this->ac_initialize_options();
					$this->ac_create_database_tables();

				}

				//switch to the current blog
				switch_to_blog( $current_blog );

			} else {

				/*
				 * if this is not a "Network Activation" create options and
				 * tables only for the current blog
				 */
				$this->ac_initialize_options();
				$this->ac_create_database_tables();

			}

		} else {

			/*
			 * if this is not a multisite installation create options and
			 * tables only for the current blog
			 */
			$this->ac_initialize_options();
			$this->ac_create_database_tables();

		}

	}

	//create the options and tables for the newly created blog
	public function new_blog_create_options_and_tables( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

		global $wpdb;

		/*
		 * if the plugin is "Network Active" create the options and tables for
		 * this new blog
		 */
		if ( is_plugin_active_for_network( 'offline-writer/init.php' ) ) {

			//get the id of the current blog
			$current_blog = $wpdb->blogid;

			//switch to the blog that is being activated
			switch_to_blog( $blog_id );

			//create options and database tables for the new blog
			$this->ac_initialize_options();
			$this->ac_create_database_tables();

			//switch to the current blog
			switch_to_blog( $current_blog );

		}

	}

	//delete options and tables for the deleted blog
	public function delete_blog_delete_options_and_tables( $blog_id ) {

		global $wpdb;

		//get the id of the current blog
		$current_blog = $wpdb->blogid;

		//switch to the blog that is being activated
		switch_to_blog( $blog_id );

		//delete options and database tables for the deleted blog
		$this->un_delete_options();
		$this->un_delete_database_tables();

		//switch to the current blog
		switch_to_blog( $current_blog );

	}

	/*
	 * initialize plugin options
	 */
	private function ac_initialize_options() {

		foreach ( $this->shared->get( 'options' ) as $key => $value ) {
			add_option( $key, $value );
		}

	}

	/*
	 * create the plugin database tables
	 */
	private function ac_create_database_tables() {

		global $wpdb;

		//Get the database character collate that will be appended at the end of each query
		$charset_collate = $wpdb->get_charset_collate();

		//check database version and create the database
		if ( intval( get_option( $this->shared->get( 'slug' ) . '_database_version' ), 10 ) < 1 ) {

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

			//create *prefix*_restriction
			$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
			$sql        = "CREATE TABLE $table_name (
                document_id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title TEXT NOT NULL DEFAULT '',
                content LONGTEXT NOT NULL DEFAULT ''
            ) $charset_collate";
			dbDelta( $sql );

			//Update database version
			update_option( $this->shared->get( 'slug' ) . '_database_version', "1" );

		}

	}

	/*
	 * plugin delete
	 */
	static public function un_delete() {

		/*
		 * delete options and tables for all the sites in the network
		 */
		if ( function_exists( 'is_multisite' ) and is_multisite() ) {

			//get the current blog id
			global $wpdb;
			$current_blog = $wpdb->blogid;

			//create an array with all the blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

			//iterate through all the blogs
			foreach ( $blogids as $blog_id ) {

				//switch to the iterated blog
				switch_to_blog( $blog_id );

				//delete options and tables for the iterated blog
				Daextulma_Admin::un_delete_options();
				Daextulma_Admin::un_delete_database_tables();

			}

			//switch to the current blog
			switch_to_blog( $current_blog );

		} else {

			/*
			 * if this is not a multisite installation delete options and
			 * tables only for the current blog
			 */
			Daextulma_Admin::un_delete_options();
			Daextulma_Admin::un_delete_database_tables();

		}

	}

	/*
	 * delete plugin options
	 */
	static public function un_delete_options() {

		//assign an instance of Daextulma_Shared
		$shared = Daextulma_Shared::get_instance();

		foreach ( $shared->get( 'options' ) as $key => $value ) {
			delete_option( $key );
		}

	}

	/*
	 * delete plugin database tables
	 */
	static public function un_delete_database_tables() {

		//assign an instance of Daextulma_Shared
		$shared = Daextulma_Shared::get_instance();

		global $wpdb;
		$table_name = $wpdb->prefix . $shared->get( 'slug' ) . "_document";
		$sql        = "DROP TABLE $table_name";
		$wpdb->query( $sql );

	}

	/*
	 * register the admin menu
	 */
	public function me_add_admin_menu() {

		$icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMi4wLjEsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDE4IDE4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxOCAxODsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2Rpc3BsYXk6bm9uZTt9DQoJLnN0MXtkaXNwbGF5OmlubGluZTt9DQoJLnN0MntkaXNwbGF5Om5vbmU7ZmlsbDojRkZGRkZGO30NCgkuc3Qze2ZpbGw6I0ZGRkZGRjtmaWx0ZXI6dXJsKCNBZG9iZV9PcGFjaXR5TWFza0ZpbHRlcik7fQ0KCS5zdDR7bWFzazp1cmwoI2FfMV8pO30NCgkuc3Q1e2Rpc3BsYXk6aW5saW5lO2ZpbGw6I0ZGRkZGRjtmaWx0ZXI6dXJsKCNBZG9iZV9PcGFjaXR5TWFza0ZpbHRlcl8xXyk7fQ0KCS5zdDZ7ZGlzcGxheTppbmxpbmU7bWFzazp1cmwoI2FfMl8pO30NCjwvc3R5bGU+DQo8ZyBpZD0iTGF5ZXJfMSIgY2xhc3M9InN0MCI+DQoJPGcgY2xhc3M9InN0MSI+DQoJCTxyZWN0IHk9IjMuNSIgY2xhc3M9InN0MiIgd2lkdGg9IjE4IiBoZWlnaHQ9IjExLjEiLz4NCgkJPHBhdGggY2xhc3M9InN0MCIgZD0iTTIuNiwxMS45VjYuMWgxLjdsMS43LDIuMmwxLjctMi4yaDEuN3Y1LjlINy44VjguNmwtMS43LDIuMkw0LjMsOC42djMuNEgyLjZ6IE0xMy40LDExLjlsLTIuNi0yLjloMS43di0zDQoJCQloMS43djNIMTZMMTMuNCwxMS45eiIvPg0KCQk8ZGVmcz4NCgkJCTxmaWx0ZXIgaWQ9IkFkb2JlX09wYWNpdHlNYXNrRmlsdGVyIiBmaWx0ZXJVbml0cz0idXNlclNwYWNlT25Vc2UiIHg9IjAiIHk9IjMuNSIgd2lkdGg9IjE4IiBoZWlnaHQ9IjExLjEiPg0KCQkJCTxmZUNvbG9yTWF0cml4ICB0eXBlPSJtYXRyaXgiIHZhbHVlcz0iMSAwIDAgMCAwICAwIDEgMCAwIDAgIDAgMCAxIDAgMCAgMCAwIDAgMSAwIi8+DQoJCQk8L2ZpbHRlcj4NCgkJPC9kZWZzPg0KCQk8bWFzayBtYXNrVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4PSIwIiB5PSIzLjUiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxMS4xIiBpZD0iYV8xXyI+DQoJCQk8cmVjdCB4PSIwIiB5PSIzLjUiIGNsYXNzPSJzdDMiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxMS4xIi8+DQoJCQk8cGF0aCBkPSJNMi42LDExLjlWNi4xaDEuN2wxLjcsMi4ybDEuNy0yLjJoMS43djUuOUg3LjhWOC42bC0xLjcsMi4yTDQuNCw4LjZ2My40SDIuNnogTTEzLjQsMTEuOWwtMi42LTIuOWgxLjd2LTNoMS43djNIMTYNCgkJCQlMMTMuNCwxMS45eiIvPg0KCQk8L21hc2s+DQoJCTxwYXRoIGNsYXNzPSJzdDQiIGQ9Ik0xLjMsMy41aDE1LjRDMTcuNCwzLjUsMTgsNCwxOCw0Ljh2OC41YzAsMC43LTAuNiwxLjMtMS4zLDEuM0gxLjNDMC42LDE0LjUsMCwxNCwwLDEzLjJWNC44DQoJCQlDMCw0LDAuNiwzLjUsMS4zLDMuNXoiLz4NCgk8L2c+DQo8L2c+DQo8ZyBpZD0iTGF5ZXJfMyIgY2xhc3M9InN0MCI+DQoJPGRlZnM+DQoJCTxmaWx0ZXIgaWQ9IkFkb2JlX09wYWNpdHlNYXNrRmlsdGVyXzFfIiBmaWx0ZXJVbml0cz0idXNlclNwYWNlT25Vc2UiIHg9IjAiIHk9IjMuNSIgd2lkdGg9IjE4IiBoZWlnaHQ9IjExLjEiPg0KCQkJPGZlQ29sb3JNYXRyaXggIHR5cGU9Im1hdHJpeCIgdmFsdWVzPSIxIDAgMCAwIDAgIDAgMSAwIDAgMCAgMCAwIDEgMCAwICAwIDAgMCAxIDAiLz4NCgkJPC9maWx0ZXI+DQoJPC9kZWZzPg0KCTxtYXNrIG1hc2tVbml0cz0idXNlclNwYWNlT25Vc2UiIHg9IjAiIHk9IjMuNSIgd2lkdGg9IjE4IiBoZWlnaHQ9IjExLjEiIGlkPSJhXzJfIiBjbGFzcz0ic3QxIj4NCgkJPHJlY3QgeD0iMCIgeT0iMy41IiBzdHlsZT0iZmlsbDojRkZGRkZGO2ZpbHRlcjp1cmwoI0Fkb2JlX09wYWNpdHlNYXNrRmlsdGVyXzFfKTsiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxMS4xIi8+DQoJCTxwYXRoIGQ9Ik0yLjYsMTEuOVY2LjFoMS43bDEuNywyLjJsMS43LTIuMmgxLjd2NS45SDcuOFY4LjZsLTEuNywyLjJMNC40LDguNnYzLjRIMi42eiBNMTMuNCwxMS45bC0yLjYtMi45aDEuN3YtM2gxLjd2M0gxNg0KCQkJTDEzLjQsMTEuOXoiLz4NCgk8L21hc2s+DQoJPHBhdGggY2xhc3M9InN0NiIgZD0iTTEuMywzLjVoMTUuNEMxNy40LDMuNSwxOCw0LDE4LDQuOHY4LjVjMCwwLjctMC42LDEuMy0xLjMsMS4zSDEuM0MwLjYsMTQuNSwwLDE0LDAsMTMuMlY0LjgNCgkJQzAsNCwwLjYsMy41LDEuMywzLjV6Ii8+DQo8L2c+DQo8ZyBpZD0iTGF5ZXJfMiI+DQoJPGcgaWQ9IkxheWVyXzQiPg0KCTwvZz4NCgk8cGF0aCBkPSJNMTYuOCwzLjVIMS4yQzAuNSwzLjUsMCw0LDAsNC43djguNmMwLDAuNywwLjUsMS4yLDEuMiwxLjJoMTUuNmMwLjcsMCwxLjItMC41LDEuMi0xLjJWNC43QzE4LDQsMTcuNSwzLjUsMTYuOCwzLjV6DQoJCSBNOS4yLDExLjlINy41VjguNmwtMS43LDIuMkw0LDguNnYzLjRIMi4zVjYuMUg0bDEuNywyLjJsMS43LTIuMmgxLjdWMTEuOXogTTEzLjEsMTEuOWwtMi42LTIuOWgxLjd2LTNIMTR2M2gxLjdMMTMuMSwxMS45eiIvPg0KPC9nPg0KPC9zdmc+DQo=';

		add_menu_page(
			esc_html__( 'UM', 'ultimate-markdown' ),
			esc_html__( 'Markdown', 'ultimate-markdown' ),
			get_option( $this->shared->get( 'slug' ) . '_documents_menu_required_capability' ),
			$this->shared->get( 'slug' ) . '-documents',
			array( $this, 'me_display_menu_documents' ),
			$icon_svg
		);

		$this->screen_id_documents = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Documents', 'ultimate-markdown' ),
			esc_html__( 'Documents', 'ultimate-markdown' ),
			get_option( $this->shared->get( 'slug' ) . '_documents_menu_required_capability' ),
			$this->shared->get( 'slug' ) . '-documents',
			array( $this, 'me_display_menu_documents' )
		);

		$this->screen_id_import = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Import', 'ultimate-markdown' ),
			esc_html__( 'Import', 'ultimate-markdown' ),
			get_option( $this->shared->get( 'slug' ) . '_import_menu_required_capability' ),
			$this->shared->get( 'slug' ) . '-import',
			array( $this, 'me_display_menu_import' )
		);

		$this->screen_id_export = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Export', 'ultimate-markdown' ),
			esc_html__( 'Export', 'ultimate-markdown' ),
			get_option( $this->shared->get( 'slug' ) . '_export_menu_required_capability' ),
			$this->shared->get( 'slug' ) . '-export',
			array( $this, 'me_display_menu_export' )
		);

		$this->screen_id_help = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Help', 'ultimate-markdown' ),
			esc_html__( 'Help', 'ultimate-markdown' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-help',
			array( $this, 'me_display_menu_help' )
		);

		$this->screen_id_pro_version = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Pro Version', 'ultimate-markdown' ),
			esc_html__( 'Pro Version', 'ultimate-markdown' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-pro-version',
			array( $this, 'me_display_menu_pro_version' )
		);

		$this->screen_id_options = add_submenu_page(
			$this->shared->get( 'slug' ) . '-documents',
			esc_html__( 'UM - Options', 'ultimate-markdown' ),
			esc_html__( 'Options', 'ultimate-markdown' ),
			'manage_options',
			$this->shared->get( 'slug' ) . '-options',
			array( $this, 'me_display_menu_options' )
		);

	}

	/*
	 * includes the documents view
	 */
	public function me_display_menu_documents() {
		include_once( 'view/documents.php' );
	}

	/*
	 * includes the import view
	 */
	public function me_display_menu_import() {
		include_once( 'view/import.php' );
	}

	/*
	 * includes the import view
	 */
	public function me_display_menu_export() {
		include_once( 'view/export.php' );
	}

	/*
	 * includes the help view
	 */
	public function me_display_menu_help() {
		include_once( 'view/help.php' );
	}

	/*
	 * includes the pro version view
	 */
	public function me_display_menu_pro_version() {
		include_once( 'view/pro_version.php' );
	}

	/*
	 * includes the options view
	 */
	public function me_display_menu_options() {
		include_once( 'view/options.php' );
	}

	/*
	 * register options
	 */
	public function op_register_options() {

		$this->menu_options->register_options();

	}

	/*
	 * The click on the "Export" button available in the "Export" menu is intercepted and the
	 * method that generates the downloadable ZIP file that includes all the markdown files generated from the
	 * documents stored in the plugin.
	 */
	public function export_controller() {

		/*
		 * Intercept requests that come from the "Export" button of the
		 * "Ultimate Markdown -> Export" menu and generate the downloadable ZIP file
		 */
		if ( isset( $_POST['daextulma_export'] ) ) {

			//verify capability
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ultimate-markdown' ) );
			}

			$file_names        = [];
			$archive_file_name = 'data-' . time() . '.zip';
			$file_path         = WP_CONTENT_DIR . '/uploads/daextulma_uploads/';

			//Create the upload directory of the plugin if the directory doesn't exist
			wp_mkdir_p( $file_path );

			//get the data from the 'connect' db
			global $wpdb;
			$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
			$document_a = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY document_id ASC", ARRAY_A );

			//if there are data iterate the array
			if ( count( $document_a ) > 0 ) {

				//Renames the items with a duplicate name
				$document_a = $this->shared->rename_duplicate_names_in_document( $document_a );

				//Add all the files in the upload folder
				foreach ( $document_a as $key => $document ) {

					$file_name    = sanitize_file_name( $document['title'] . '.md' );
					$file_names[] = $file_name;

					//Create the single markdown file in the plugin upload folder
					$content = $document['content'];
					$fp      = fopen( $file_path . "/" . $file_name, "wb" );
					fwrite( $fp, $content );
					fclose( $fp );

				}


				//Create and open a new zip archive
				$zip = new ZipArchive();
				if ( $zip->open( $archive_file_name, ZIPARCHIVE::CREATE ) !== true ) {
					die( "cannot open " . $archive_file_name );
				}

				//Add each files of the $file_name array to the archive
				foreach ( $file_names as $files ) {
					$zip->addFile( $file_path . $files, $files );
				}
				$zip->close();

				//Generate the header of a zip file
				header( "Content-type: application/zip" );
				header( "Content-Disposition: attachment; filename=" . $archive_file_name );
				header( "Pragma: no-cache" );
				header( "Expires: 0" );
				readfile( $archive_file_name );

				//Delete all the files used to create the archive
				foreach ( $file_names as $file_name ) {
					unlink( $file_path . $file_name );
				}

			} else {
				return false;
			}

			die();

		}

	}

	/**
	 * Echo all the dismissible notices based on the values of the $notices array.
	 *
	 * @param $notices
	 */
	public function dismissible_notice( $notices ) {

		foreach ( $notices as $key => $notice ) {
			echo '<div class="' . esc_attr( $notice['class'] ) . ' settings-error notice is-dismissible below-h2"><p>' . esc_html( $notice['message'] ) . '</p></div>';
		}

	}

}