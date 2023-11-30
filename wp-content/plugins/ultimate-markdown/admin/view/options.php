<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_attr__( 'You do not have sufficient capabilities to access this page.', 'ultimate-markdown' ) );
}

//Sanitization -------------------------------------------------------------------------------------------------
$data['settings_updated'] = isset( $_GET['settings-updated'] ) ? sanitize_key( $_GET['settings-updated'], 10 ) : null;
$data['active_tab']       = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general_options';

?>

<div class="wrap">

    <h2><?php esc_attr_e( 'Ultimate Markdown - Options', 'ultimate-markdown' ); ?></h2>

	<?php

	//settings errors
	if ( ! is_null( $data['settings_updated'] ) and $data['settings_updated'] == 'true' ) {
		settings_errors();
	}

	?>

    <div id="daext-options-wrapper">

        <div class="nav-tab-wrapper">
            <a href="?page=daextulma-options&tab=general_options"
               class="nav-tab nav-tab-active"><?php esc_attr_e( 'General', 'ultimate-markdown' ); ?></a>
        </div>

        <form method='post' action='options.php' autocomplete="off">

			<?php

			if ( $data['active_tab'] == 'general_options' ) {

				settings_fields( $this->shared->get( 'slug' ) . '_general_options' );
				do_settings_sections( $this->shared->get( 'slug' ) . '_general_options' );

			}

			?>

            <div class="daext-options-action">
                <input type="submit" name="submit" id="submit" class="button"
                       value="<?php esc_attr_e( 'Save Changes', 'ultimate-markdown' ); ?>">
            </div>

        </form>

    </div>

</div>