<?php

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ultimate-markdown' ) );
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_html_e( 'Ultimate Markdown - Pro Version', 'ultimate-markdown' ); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php echo esc_html__( 'For professional users, we distribute a',
					'ultimate-markdown' ) . ' <a href="https://daext.com/ultimate-markdown/">' . esc_attr__( 'Pro Version',
					'ultimate-markdown' ) . '</a> ' . esc_html__( 'of this plugin.',
					'ultimate-markdown' ) . '</p>'; ?>
        <h2><?php esc_html_e( 'Additional Features Included in the Pro Version', 'ultimate-markdown' ); ?></h2>
        <ul>
            <li><?php echo esc_html__( 'Ability to mass export the WordPress posts as Markdown documents','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Ability to mass export the internal archive of Markdown documents','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Ability to export single Markdown documents','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Advanced export options','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Post sidebar section to convert the edited articles to a Markdown files','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'REST API endpoint to send Markdown documents to your WordPress website from any external application','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'REST API endpoint to read data from the internal archive of Markdown documents','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Classic Editor support','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Additional Markdown parsers','ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( 'Additional options to set custom menu capabilities for all the plugin menus','ultimate-markdown' ); ?></li>
        </ul>
        <h2><?php esc_html_e( 'Additional Benefits of the Pro Version', 'ultimate-markdown' ); ?></h2>
        <ul>
            <li><?php esc_html_e( '24 hours support provided 7 days a week', 'ultimate-markdown' ); ?></li>
            <li><?php echo esc_html__( '30 day money back guarantee (more information is available in the',
						'ultimate-markdown' ) . ' <a href="https://daext.com/refund-policy/">' . esc_html__( 'Refund Policy',
						'ultimate-markdown' ) . '</a> ' . esc_html__( 'page', 'ultimate-markdown' ) . ')'; ?></li>
        </ul>
        <h2><?php esc_html_e( 'Get Started', 'ultimate-markdown' ); ?></h2>
        <p><?php echo esc_html__( 'Download the',
					'ultimate-markdown' ) . ' <a href="https://daext.com/ultimate-markdown/">' . esc_html__( 'Pro Version',
					'ultimate-markdown' ) . '</a> ' . esc_html__( 'now by selecting one of the available plans.',
					'ultimate-markdown' ); ?></p>
    </div>

</div>

