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

	// This will be needed for featured block for the sample image URLs.
	wp_localize_script(
		'travel-editor-blocks-js',
		'travel_globals',
		array(
			'theme_url' => esc_url( get_template_directory_uri() ),
		)
	);

	// This file's content is directly copied from the Travel theme static template.
	// @todo Use only style that's actually needed within the editor.
	wp_enqueue_style(
		'travel-editor-blocks-css',
		get_template_directory_uri() . '/blocks/editor-blocks.css',
		array( 'wp-blocks' )
	);
}

// Hook into block editor assets.
add_action( 'enqueue_block_editor_assets', 'travel_enqueue_editor_scripts' );
