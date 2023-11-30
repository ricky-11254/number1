<?php

if ( ! current_user_can( get_option( $this->shared->get( 'slug' ) . '_documents_menu_required_capability' ) ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ultimate-markdown' ) );
}

?>

<!-- process data -->

<?php

//Initialize variables -------------------------------------------------------------------------------------------------
$dismissible_notice_a = [];

//Preliminary operations -----------------------------------------------------------------------------------------------
global $wpdb;

//Sanitization ---------------------------------------------------------------------------------------------

//Actions
$data['edit_id']        = isset( $_GET['edit_id'] ) ? intval( $_GET['edit_id'], 10 ) : null;
$data['delete_id']      = isset( $_POST['delete_id'] ) ? intval( $_POST['delete_id'], 10 ) : null;
$data['clone_id']       = isset( $_POST['clone_id'] ) ? intval( $_POST['clone_id'], 10 ) : null;
$data['update_id']      = isset( $_POST['update_id'] ) ? intval( $_POST['update_id'], 10 ) : null;
$data['form_submitted'] = isset( $_POST['form_submitted'] ) ? intval( $_POST['form_submitted'], 10 ) : null;

//Filter and search data
$data['s'] = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : null;

if ( ! is_null( $data['update_id'] ) or ! is_null( $data['form_submitted'] ) ) {

	//Main Form data
	$data['title']   = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : null;
	$data['content'] = isset( $_POST['content'] ) ? sanitize_textarea_field( $_POST['content'] ) : null;

}

//Validation -----------------------------------------------------------------------------------------------

if ( ! is_null( $data['update_id'] ) or ! is_null( $data['form_submitted'] ) ) {

	//validation on "title"
	if ( mb_strlen( trim( $data['title'] ) ) === 0 or mb_strlen( trim( $data['title'] ) ) > 100 ) {

		$dismissible_notice_a[] = [
			'message' => __( 'Please enter a valid value in the "Title" field.', 'ultimate-markdown' ),
			'class'   => 'error'
		];
		$invalid_data           = true;

	}

}

//update ---------------------------------------------------------------
if ( ! is_null( $data['update_id'] ) and ! isset( $invalid_data ) ) {

	//update the database
	$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
	$safe_sql   = $wpdb->prepare( "UPDATE $table_name SET 
                title = %s,
                 content = %s
                WHERE document_id = %d",
		$data['title'],
		$data['content'],
		$data['update_id'] );

	$query_result = $wpdb->query( $safe_sql );

	if ( $query_result !== false ) {

		$dismissible_notice_a[] = [
			'message' => __( 'The document has been successfully updated.', 'ultimate-markdown' ),
			'class'   => 'updated'
		];

	}

} else {

	//add ------------------------------------------------------------------
	if ( ! is_null( $data['form_submitted'] ) and ! isset( $invalid_data ) ) {

		//insert into the database
		$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
		$safe_sql   = $wpdb->prepare( "INSERT INTO $table_name SET 
                    title = %s,
                    content = %s",
			$data['title'],
			$data['content']
		);

		$query_result = $wpdb->query( $safe_sql );

		if ( $query_result !== false ) {
			$dismissible_notice_a[] = [
				'message' => __( 'The document has been successfully added.', 'ultimate-markdown' ),
				'class'   => 'updated'
			];
		}

	}

}

//delete a document
if ( ! is_null( $data['delete_id'] ) ) {

	//delete this document
	$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
	$safe_sql   = $wpdb->prepare( "DELETE FROM $table_name WHERE document_id = %d ", $data['delete_id'] );

	$query_result = $wpdb->query( $safe_sql );

	if ( $query_result !== false ) {
		$dismissible_notice_a[] = [
			'message' => __( 'The document has been successfully deleted.', 'ultimate-markdown' ),
			'class'   => 'updated'
		];
	}

}

//clone the term group
if ( ! is_null( $data['clone_id'] ) ) {

	//clone the document
	$table_name = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
	$query_result_1 = $wpdb->query( "CREATE TEMPORARY TABLE daextulma_temporary_table SELECT * FROM $table_name WHERE document_id = " . $data['clone_id'] );
	$query_result_2 = $wpdb->query( "UPDATE daextulma_temporary_table SET document_id = NULL" );
	$query_result_3 = $wpdb->query( "INSERT INTO $table_name SELECT * FROM daextulma_temporary_table" );
	$query_result_4 = $wpdb->query( "DROP TEMPORARY TABLE IF EXISTS daextulma_temporary_table" );

	if ( intval($query_result_1, 10) === 1 and
	     intval($query_result_2, 10) === 1 and
	     intval($query_result_3, 10) === 1 and
	     intval($query_result_4, 10) === 1 ) {

		$dismissible_notice_a[] = [
			'message' => __( 'The document has been successfully cloned.', 'ultimate-markdown' ),
			'class'   => 'updated'
		];

	}

}

//get the document data
if ( ! is_null( $data['edit_id'] ) ) {
	$table_name   = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
	$safe_sql     = $wpdb->prepare( "SELECT * FROM $table_name WHERE document_id = %d ", $data['edit_id'] );
	$document_obj = $wpdb->get_row( $safe_sql );
}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_html_e( 'Ultimate Markdown - Documents', 'ultimate-markdown' ); ?></h2>

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daextulma-documents">

            <p><?php esc_html_e( 'Perform your Search', 'ultimate-markdown' ); ?></p>

			<?php
			if ( ! is_null( $data['s'] ) ) {
				if ( mb_strlen( trim( $data['s'] ) ) > 0 ) {
					$search_string = $data['s'];
				} else {
					$search_string = '';
				}
			} else {
				$search_string = '';
			}

			?>

            <input type="text" name="s"
                   value="<?php echo esc_attr( stripslashes( $search_string ) ); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="" aria-label="<?php esc_attr_e('Search', 'daext-commerce'); ?>">

        </form>

    </div>

    <div id="daext-menu-wrapper">

		<?php $this->dismissible_notice( $dismissible_notice_a ); ?>

        <!-- table -->

		<?php

		$filter = '';

		//create the query part used to filter the results when a search is performed
		if ( ! is_null( $data['s'] ) ) {

			if ( mb_strlen( trim( $data['s'] ) ) > 0 ) {

				//create the query part used to filter the results when a search is performed
				$filter = $wpdb->prepare( 'WHERE (document_id LIKE %s OR title LIKE %s)',
					'%' . $data['s'] . '%',
					'%' . $data['s'] . '%' );

			}

		}

		//retrieve the total number of documents
		$table_name  = $wpdb->prefix . $this->shared->get( 'slug' ) . "_document";
		$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $filter" );

		//Initialize the pagination class
		require_once( $this->shared->get( 'dir' ) . '/admin/inc/class-daextulma-pagination.php' );
		$pag = new daextulma_pagination();
		$pag->set_total_items( $total_items );//Set the total number of items
		$pag->set_record_per_page( 10 ); //Set records per page
		$pag->set_target_page( "admin.php?page=" . $this->shared->get( 'slug' ) . "-documents" );//Set target page
		$pag->set_current_page();//set the current page number from $_GET

		?>

        <!-- Query the database -->
		<?php
		$query_limit = $pag->query_limit();
		$results     = $wpdb->get_results( "SELECT * FROM $table_name $filter ORDER BY document_id DESC $query_limit",
			ARRAY_A ); ?>

		<?php if ( count( $results ) > 0 ) : ?>

            <div class="daext-items-container">

                <!-- list of tables -->
                <table class="daext-items">
                    <thead>
                    <tr>
                        <th>
                            <div><?php esc_html_e( 'Document ID', 'ultimate-markdown' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The ID of the document.', 'ultimate-markdown' ); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_html_e( 'Title', 'ultimate-markdown' ); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The title of the document.', 'ultimate-markdown' ); ?>"></div>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

					<?php foreach ( $results as $result ) : ?>
                        <tr>
                            <td><?php echo intval( $result['document_id'], 10 ); ?></td>
                            <td><?php echo esc_html( stripslashes( $result['title'] ) ); ?></td>
                            <td class="icons-container">
                                <form method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-documents">
                                    <input type="hidden" name="clone_id"
                                           value="<?php echo esc_attr( $result['document_id'] ); ?>">
                                    <input class="menu-icon clone help-icon" type="submit" value=""
                                           aria-label="<?php esc_attr_e('Clone document', 'daext-commerce'); ?>">
                                </form>
                                <a class="menu-icon edit"
                                   href="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-documents&edit_id=<?php echo esc_attr( $result['document_id'] ); ?>"
                                   aria-label="<?php esc_attr_e('Edit document', 'daext-commerce'); ?>"></a>
                                <form id="form-delete-<?php echo esc_attr( $result['document_id'] ); ?>" method="POST"
                                      action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-documents">
                                    <input type="hidden" value="<?php echo esc_attr( $result['document_id'] ); ?>"
                                           name="delete_id">
                                    <input class="menu-icon delete" type="submit" value=""
                                           aria-label="<?php esc_attr_e('Delete document', 'daext-commerce'); ?>">
                                </form>
                            </td>
                        </tr>
					<?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- Display the pagination -->
			<?php if ( $pag->total_items > 0 ) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo esc_html( $pag->total_items ); ?>&nbsp<?php esc_html_e( 'items', 'ultimate-markdown' ); ?></span>
						<?php $pag->show(); ?>
                    </div>
                </div>
			<?php endif; ?>

		<?php else : ?>

			<?php

			if ( mb_strlen( trim( $filter ) ) > 0 ) {
				echo '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_html__( 'There are no results that match your filter.', 'ultimate-markdown' ) . '</p></div>';
			}

			?>

		<?php endif; ?>

        <form method="POST" action="admin.php?page=<?php echo esc_attr( $this->shared->get( 'slug' ) ); ?>-documents"
              autocomplete="off">

            <input type="hidden" value="1" name="form_submitted">

			<?php if ( ! is_null( $data['edit_id'] ) ) : ?>

            <!-- Edit an Document -->

            <div class="daext-form-container">

                <h3 class="daext-form-title"><?php esc_html_e( 'Edit Document', 'ultimate-markdown' ); ?>
                    &nbsp<?php echo esc_html( $document_obj->document_id ); ?></h3>

                <table class="daext-form daext-form-table">

                    <input type="hidden" name="update_id"
                           value="<?php echo esc_attr( $document_obj->document_id ); ?>"/>

                    <!-- Title -->
                    <tr valign="top">
                        <th><label for="title"><?php esc_html_e( 'Title', 'ultimate-markdown' ); ?></label></th>
                        <td>
                            <input value="<?php echo esc_attr( stripslashes( $document_obj->title ) ); ?>" type="text"
                                   id="title" maxlength="255" size="30" name="title"/>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The title of the document.', 'ultimate-markdown' ); ?>"></div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr valign="top">
                        <th><label for="content"><?php esc_html_e( 'Content', 'ultimate-markdown' ); ?></label></th>
                        <td>
                            <div id="editor-container">
                                <textarea id="content" maxlength="1000000" size="30"
                                          name="content"><?php echo esc_html( stripslashes( $document_obj->content ) ); ?></textarea>
                                <div id="editor-render"></div>
                            </div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e( 'The Markdown text of the document.', 'ultimate-markdown' ); ?>"></div>
                        </td>
                    </tr>

                </table>

                <!-- submit button -->
                <div class="daext-form-action">
                    <input class="button" type="submit"
                           value="<?php esc_attr_e( 'Update Document', 'ultimate-markdown' ); ?>">
                    <input id="cancel" class="button" type="submit"
                           value="<?php esc_attr_e( 'Cancel', 'ultimate-markdown' ); ?>">
                </div>

				<?php else : ?>

                <!-- Create New Document -->

                <div class="daext-form-container">

                    <div class="daext-form-title"><?php esc_html_e( 'Create New Document', 'ultimate-markdown' ); ?></div>

                    <table class="daext-form daext-form-table">

                        <!-- Title -->
                        <tr valign="top">
                            <th scope="row"><label
                                        for="title"><?php esc_html_e( 'Title', 'ultimate-markdown' ); ?></label></th>
                            <td>
                                <input type="text" id="title" maxlength="100" size="30" name="title"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The title of the document.', 'ultimate-markdown' ); ?>"></div>
                            </td>
                        </tr>

                        <!-- Content -->
                        <tr valign="top">
                            <th scope="row"><label
                                        for="name"><?php esc_html_e( 'Content', 'ultimate-markdown' ); ?></label></th>
                            <td>
                                <div id="editor-container">
                                    <textarea id="content" maxlength="1000000" size="30" name="content"></textarea>
                                    <div id="editor-render"></div>
                                </div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e( 'The Markdown text of the document.', 'ultimate-markdown' ); ?>"></div>
                            </td>
                        </tr>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit"
                               value="<?php esc_attr_e( 'Add Document', 'ultimate-markdown' ); ?>">
                    </div>

					<?php endif; ?>

                </div>

        </form>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e( 'Delete the document?', 'ultimate-markdown' ); ?>"
     class="daext-display-none">
    <p><?php esc_html_e( 'This document will be permanently deleted and cannot be recovered. Are you sure?', 'ultimate-markdown' ); ?></p>
</div>