<?php

/**
 * Enqueue JS for block editor only.
 */
function travel_enqueue_editor_scripts()
{

	// Enqueue JS bundled file.
	wp_enqueue_script(
		'travel-editor-blocks-js',
		get_template_directory_uri() . '/assets/js/editor-blocks.js',
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
	);
}

// Hook into block editor assets.
add_action( 'enqueue_block_editor_assets', 'travel_enqueue_editor_scripts' );
