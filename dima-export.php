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
		'Dima Export', // Page title
		'Dima Export', // Menu title
		'manage_options', // Capability
		'dima-export', // Menu slug
		'dima_export_page_settings_page' // Callback function
	);
}

add_action( 'admin_menu', 'export_page_by_id_register_settings_page' );

// Display the plugin settings page
function dima_export_page_settings_page() {
	 // Check if the form was submitted
	if ( isset( $_POST['page_id'] ) ) {
		require_once plugin_dir_path( __FILE__ ) . '/export.php';

		$page_id = intval( $_POST['page_id'] ); // Get the page ID from the form
		if ( 0 !== $page_id ) {
			$defaults = array(
				'content' => 'page',
				'page_id' => $page_id,
			);
		} else {
			$defaults = array(
				'content' => 'all',
			);
		}

		$defaults = apply_filters( 'export_args', $defaults );
		dima_export_wp( $defaults );
		die();
	}
	?>
	<div class="wrap">
		<h1>Export Page</h1>
		<form method="post" id="export-form"
		<label for="page_id">Select the page that you want to export:</label><br><br>
			<?php
			// Query to get all pages
			$pages = get_pages();
			// Start the <select> element
			echo '<select name="page_id">';
			echo '<option value="0">All content</option>';
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
