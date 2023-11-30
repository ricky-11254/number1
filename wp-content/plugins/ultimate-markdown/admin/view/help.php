<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ultimate-markdown' ) );
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e( 'Ultimate Markdown - Help', 'ultimate-markdown' ); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php esc_html_e( 'Visit the resources below to find your answers or to ask questions directly to the plugin developers.',
				'ultimate-markdown' ); ?></p>
        <ul>
            <li><a href="https://daext.com/doc/ultimate-markdown/"><?php esc_html_e( 'Plugin Documentation', 'ultimate-markdown' ); ?>
            <li><a href="https://daext.com/support/"><?php esc_html_e( 'Support Conditions', 'ultimate-markdown' ); ?>
            </li>
            <li><a href="https://daext.com"><?php esc_html_e( 'Developer Website', 'ultimate-markdown' ); ?></a></li>
            <li><a href="https://daext.com/ultimate-markdown/"><?php esc_html_e( 'Pro Version', 'ultimate-markdown' ); ?></a></li>
            <li>
                <a href="https://wordpress.org/plugins/ultimate-markdown/"><?php esc_html_e( 'WordPress.org Plugin Page',
						'ultimate-markdown' ); ?></a></li>
            <li>
                <a href="https://wordpress.org/support/plugin/ultimate-markdown/"><?php esc_html_e( 'WordPress.org Support Forum',
						'ultimate-markdown' ); ?></a></li>
        </ul>
        <p>

    </div>

</div>