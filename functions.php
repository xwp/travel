<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

/**
 * Enqueue JS for block editor only.
 */
function travel_enqueue_editor_scripts() {

	// If Gutenberg doesn't exist, don't load any scripts.
	if ( ! function_exists( 'gutenberg_init' ) ) {
		return;
	}

	// Enqueue JS bundled file.
	wp_enqueue_script(
		'travel-editor-blocks-js',
		get_template_directory_uri() . '/assets/js/editor-blocks.js',
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
	);

	// This will be needed for featured block for the sample image URLs.
	wp_localize_script(
		'travel-editor-blocks-js',
		'travelGlobals',
		array(
			'themeUrl' => esc_url( get_template_directory_uri() ),
		)
	);

	// This file's content is directly copied from the Travel theme static template.
	// @todo Use only style that's actually needed within the editor.
	wp_enqueue_style(
		'travel-editor-blocks-css',
		get_template_directory_uri() . '/assets/css/editor-blocks.css',
		array( 'wp-blocks' )
	);
}

// Hook into block editor assets.
add_action( 'enqueue_block_editor_assets', 'travel_enqueue_editor_scripts' );

/**
 * Replaces data-amp-bind-* with [*].
 * This is a workaround for React considering some AMP attributes (e.g. [src]) invalid.
 *
 * @param string $content Content.
 * @return mixed
 */
function travel_filter_the_content_amp_atts( $content ) {
	if ( ! function_exists( 'gutenberg_init' ) ) {
		return $content;
	}

	return preg_replace( '/\sdata-amp-bind-(.+?)=/', ' [$1]=', $content );
}

add_filter( 'the_content', 'travel_filter_the_content_amp_atts', 10, 1 );
