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
 * Front-side render for Travel Discovery block.
 *
 * @param array $attributes Block attributes.
 * @return string Output.
 */
function travel_render_block_travel_discover( $attributes ) {
	global $post;

	$posts = wp_get_recent_posts( array(
		'numberposts' => 1,
		'post_status' => 'publish',
		'post_type'   => 'post',
	) );

	$heading    = $attributes['heading'];
	$subheading = $attributes['subheading'];

	// If there's no post, set placeholders.
	if ( empty( $posts ) ) {
		$title   = __( 'From the blog', 'travel' );
		$excerpt = __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit amet dolor set.' );
		$link    = '#';
	} else {
		$discover_post = $posts[0];
		$title         = get_the_title( $discover_post['ID'] );
		$link          = get_permalink( $discover_post['ID'] );

		// If the Discover Post is the same as the current post, use the wp_trim_words directly since otherwise the_content will run endlessly.
		if (
			$post
			&&
			$post->ID === $discover_post['ID']
			&&
			! has_excerpt( $discover_post['post_excerpt'] )
		) {
			$excerpt_length = apply_filters( 'excerpt_length', 15 );
			$excerpt_more   = apply_filters( 'excerpt_more', ' ...' );
			$excerpt        = wp_trim_words( $discover_post['post_content'], $excerpt_length, $excerpt_more );
		} else {
			$excerpt = get_the_excerpt( $discover_post['ID'] );
		}
	}

	$output = "<section class='travel-discover py4 mb3 relative xs-hide sm-hide'>
					<div class='max-width-3 mx-auto px1 md-px2'>
						<div class='flex justify-between items-center'>
							<header>
								<h2 class='travel-discover-heading bold line-height-2 xs-hide sm-hide'>" . esc_attr( $heading ) . "</h2>
								<div class='travel-discover-subheading h2 xs-hide sm-hide'>" . esc_attr( $subheading ) . "</div>
							</header>

							<div class='travel-discover-panel travel-shadow-hover px3 py2 ml1 mr3 myn3 xs-hide sm-hide'>
								<div class='bold h2 line-height-2 my1'>" . esc_html( $title ) . "</div>
								<p class='travel-discover-panel-subheading h3 my1 line-height-2'>
									" . esc_html( $excerpt ) . "
								</p>
								<p class='my1'>
									<a class='travel-link' href=' " . $link . "'>Read more</a>
								</p>
							</div>
						</div>
					</div>
				</section>";

	return $output;

}

/**
 * Register Travel Discover block type.
 */
function travel_register_block_travel_discover() {
	if ( function_exists( 'register_block_type' ) ) {
		register_block_type( 'amp-travel/discover', array(
			'attributes'      => array(
				'heading'    => array(
					'type'    => 'string',
					'default' => __( 'Discover Adventures', 'travel' ),
				),
				'subheading' => array(
					'type'    => 'string',
					'default' => __( 'Get inspired and find your next big trip', 'travel' ),
				),
			),
			'render_callback' => 'travel_render_block_travel_discover',
		) );
	}
}
add_action( 'init', 'travel_register_block_travel_discover' );
