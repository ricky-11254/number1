<?php

if ( ! current_user_can( get_option( $this->shared->get( 'slug' ) . '_import_menu_required_capability' ) ) ) {
	wp_die( esc_attr__( 'You do not have sufficient permissions to access this page.', 'ultimate-markdown' ) );
}

?>

<!-- process data -->

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e( 'Ultimate Markdown - Import', 'ultimate-markdown' ); ?></h2>

    <div id="daext-menu-wrapper">

		<?php

		//process the Markdown file upload
		if ( isset( $_FILES['file_to_upload'] ) ) {

			$generated_a   = [];
			$list_of_posts = [];

			//process all the uploaded files
			for ( $i = 0; $i <= ( count( $_FILES['file_to_upload']['name'] ) - 1 ); $i ++ ) {

				$file_data = $this->shared->sanitize_uploaded_file( [
					'name'     => $_FILES['file_to_upload']['name'][ $i ],
					'type'     => $_FILES['file_to_upload']['type'][ $i ],
					'tmp_name' => $_FILES['file_to_upload']['tmp_name'][ $i ],
					'error'    => $_FILES['file_to_upload']['error'][ $i ],
					'size'     => $_FILES['file_to_upload']['size'][ $i ]
				] );

				//Get the markdown content of the file
				$markdown_content = $this->shared->get_markdown_file_content( $file_data );

				$title = sanitize_text_field( $this->shared->get_title_from_file_name( $file_data['name'] ) );

				//Create a new record in the "document" database table created by the plugin -------------------
				global $wpdb;
				$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
				$safe_sql   = $wpdb->prepare( "INSERT INTO $table_name SET 
                            title = %s,
                            content = %s",
					$title,
					$markdown_content
				);

				$query_result = $wpdb->query( $safe_sql );

				if ( $query_result !== false ) {
					$list_of_posts[] = [
						'id'    => $wpdb->insert_id,
						'title' => $title
					];
				}

			}

			echo '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_html__( 'The following documents have been generated:', 'ultimate-markdown' ) . '&nbsp';
			foreach ( $list_of_posts as $key => $post ) {
				echo '<a href="admin.php?page=daextulma-documents&edit_id=' . intval( $post['id'], 10 ) . '&action=edit">' . esc_html( $post['title'] ) . '</a>';
				if ( $key < count( $list_of_posts ) - 1 ) {
					echo ',&nbsp';
				}else{
					echo '.';
                }
			}
			echo '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_html__( 'Dismiss this notice.', 'ultimate-markdown' ) . '</span></button></div>';

		}

		?>

		<?php if ( ! isset( $hide_upload_form ) ) : ?>
            <p><?php esc_html_e( 'Choose one or more Markdown files (.md .markdown .mdown .mkdn .mkd .mdwn .mdtxt .mdtext .text .txt) to upload, then click Upload files and import.', 'ultimate-markdown' ); ?></p>
            <form enctype="multipart/form-data" id="import-upload-form" method="post" class="wp-upload-form"
                  action="">
                <p>
                    <label for="upload"><?php esc_html_e( 'Choose files from your computer:', 'ultimate-markdown' ); ?></label>
                    <input type="file" id="upload" name="file_to_upload[]" accept=".md,.markdown,.mdown,.mkdn,.mkd,.mdwn,.mdtxt,.mdtex,.text,.txt" multiple>
                </p>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                         value="<?php esc_attr_e( 'Upload files and import', 'ultimate-markdown' ); ?>">
                </p>
            </form>
		<?php endif; ?>

    </div>

</div>