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
			'apiUrl'   => get_rest_url(),
			'siteUrl'  => site_url(),
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
 * Replaces data-ampsrc with [src].
 * This is a workaround for React considering [src] as an invalid attribute.
 *
 * @todo Confirm if this makes sense / if there's a better way.
 * @param string $content Content.
 * @return mixed
 */
function travel_filter_the_content_amp_atts( $content ) {
	if ( ! function_exists( 'gutenberg_init' ) ) {
		return $content;
	}

	if ( is_singular() ) {
		$content = str_replace( 'data-ampsrc=', '[src]=', $content );
		return $content;
	}
}

add_filter( 'the_content', 'travel_filter_the_content_amp_atts', 10, 1 );

/**
 * Filters the rest_pre_echo_response for amp-list categories.
 *
 * @param array           $result  Response data to send to the client.
 * @param WP_REST_Server  $server  Server instance.
 * @param WP_REST_Request $request Request used to generate the response.
 * @return array
 */
function travel_filter_rest_pre_echo_response( $result, $server, $request ) {

	// Amp-list is processing JSON in a specific way, also requires items array.
	if ( false !== strpos( $request->get_route(), 'categories' ) ) {
		$items = array(
			'items' => array(
				array(
					'categories' => $result,
				),
			),
		);
		return $items;
	}
	return $result;
}
add_filter( 'rest_pre_echo_response', 'travel_filter_rest_pre_echo_response', 10, 3 );
