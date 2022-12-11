<?php

/**
 * Plugin Name: Dima Export
 * Plugin URI:
 * Description: Exports a page by its ID
 * Version: 1.0
 * Author: Adel Tahri
 * Author URI:
 */

// Register the plugin settings page
function export_page_by_id_register_settings_page() {
	add_options_page(
		'Export Page by ID', // Page title
		'Export Page by ID', // Menu title
		'manage_options', // Capability
		'export-page-by-id', // Menu slug
		'export_page_by_id_settings_page' // Callback function
	);
}

add_action( 'admin_menu', 'export_page_by_id_register_settings_page' );

// Display the plugin settings page
function export_page_by_id_settings_page() {
	// Check if the form was submitted
	if ( isset( $_POST['page_id'] ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/export.php';

		$page_id  = intval( $_POST['page_id'] ); // Get the page ID from the form
		$defaults = array(
			'content' => 'page',
			'page_id' => $page_id,
		);

		$defaults = apply_filters( 'export_args', $defaults );
		dima_export_wp( $defaults );
		die();
	}
	?>
	<div class="wrap">
		<h1>Export Page by ID Settings</h1>
		<form method="post" id="export-form" action="?page=export-page-by-id" <label for="page_id">Enter the ID of the page that you want to export:</label><br>
			<input type="hidden" name="page" value="export-page-by-id""><br>
			<!-- <input type=" text" id="page_id" name="page_id"><br> -->
			<?php
			// Query to get all pages
			$pages = get_pages();
			// Start the <select> element
			echo '<select name="page_id">';

			// Loop through the pages and display each page name and ID in the <select> element
			foreach ( $pages as $page ) {
				echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
			}

			// End the <select> element
			echo '<select>';
			?>

			<?php submit_button( __( 'Download Export File' ) ); ?>
		</form>
	</div>
	<?php
}
