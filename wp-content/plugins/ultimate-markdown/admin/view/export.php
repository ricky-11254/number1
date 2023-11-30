<?php

if ( ! current_user_can( get_option( $this->shared->get( 'slug' ) . '_export_menu_required_capability' ) ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'dahm' ) );
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e( 'Ultimate Markdown - Export', 'dahm' ); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php esc_html_e( 'Click the Export button to generate a ZIP file that includes all your markdown documents.', 'ultimate-markdown' ); ?></p>

        <!-- the data sent through this form are handled by the export_controller() method called with the WordPress init action -->
        <form method="POST" action="admin.php?page=daextulma-export">

            <div class="daext-widget-submit">
                <input name="daextulma_export" class="button button-primary" type="submit"
                       value="<?php esc_attr_e( 'Export', 'dahm' ); ?>" <?php if ( $this->shared->number_of_documents() === 0 ) {
					echo 'disabled="disabled"';
				} ?>>
            </div>

        </form>

    </div>

</div>