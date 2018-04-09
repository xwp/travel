<?php
/**
 * AMP Travel blocks class.
 *
 * @package WPAMPTheme
 */

/**
 * Class AMP_Travel_Blocks.
 *
 * @package WPAMPTheme
 */
class AMP_Travel_Blocks {

	/**
	 * AMP_Travel_Blocks constructor.
	 */
	public function __construct() {
		if ( function_exists( 'gutenberg_init' ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
			add_filter( 'the_content', array( $this, 'filter_the_content_amp_atts' ), 10, 1 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );

			add_action( 'init', array( $this, 'register_block_travel_popular' ) );

			// @todo Change 'post' to 'adventure'.
			add_filter( 'rest_post_collection_params', array( $this, 'filter_rest_post_collection_params' ), 10, 1 );
			add_filter( 'rest_post_query', array( $this, 'filter_rest_post_query' ), 10, 2 );
		}
	}

	/**
	 * Frontend render for Popular block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string Output.
	 */
	public function render_block_travel_popular( $attributes ) {
		return '';
	}

	/**
	 * Register Travel Popular block.
	 */
	public function register_block_travel_popular() {
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type( 'amp-travel/popular', array(
				'attributes'      => array(
					'heading' => array(
						'type'    => 'string',
						'default' => __( 'Top Adventures', 'travel' ),
					),
				),
				'render_callback' => array( $this, 'render_block_travel_popular' ),
			) );
		}
	}

	/**
	 * Change query args to include meta_key and meta_type.
	 *
	 * @param array           $args Query args.
	 * @param WP_REST_Request $request Request object.
	 * @return array
	 */
	public function filter_rest_post_query( $args, $request ) {
		$order_key = $request->get_param( 'orderby' );
		$meta_key  = $request->get_param( 'meta_key' );
		if ( ! empty( $order_key ) && 'meta_value_num' === $order_key && 'amp_travel_rating' === $meta_key ) {
			$args['meta_key']  = $meta_key;
			$args['meta_type'] = 'DECIMAL';
		}

		return $args;
	}

	/**
	 * Filter the REST accepted params to accept ordering by 'rating'.
	 *
	 * @todo Change this to 'adventure'.
	 * @param array $query_params Collection params.
	 * @return mixed Collection params.
	 */
	public function filter_rest_post_collection_params( $query_params ) {

		$query_params['orderby']['enum'][] = 'meta_value_num';
		$query_params['meta_key']          = array(
			'description'       => __( 'The meta key to query.', 'travel' ),
			'type'              => 'string',
			'enum'              => array( 'amp_travel_rating' ),
			'validate_callback' => 'rest_validate_request_arg',
		);
		return $query_params;
	}

	/**
	 * Replaces data-amp-bind-* with [*].
	 * This is a workaround for React considering some AMP attributes (e.g. [src]) invalid.
	 *
	 * @param string $content Content.
	 * @return mixed
	 */
	public function filter_the_content_amp_atts( $content ) {
		return preg_replace( '/\sdata-amp-bind-(.+?)=/', ' [$1]=', $content );
	}

	/**
	 * Enqueue editor scripts.
	 */
	public function enqueue_editor_scripts() {

		// Enqueue JS bundled file.
		wp_enqueue_script(
			'travel-editor-blocks-js',
			get_template_directory_uri() . '/assets/js/editor-blocks.js',
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
		);

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

	/**
	 * Add the amp-specific html tags required by theme to allowed tags.
	 *
	 * @param array  $allowed_tags Allowed tags.
	 * @param string $context Context.
	 * @return array Modified tags.
	 */
	public function filter_wp_kses_allowed_html( $allowed_tags, $context ) {
		if ( 'post' === $context ) {
			$amp_tags = array(
				'amp-img'  => array_merge( $allowed_tags['img'], array(
					'attribution' => true,
					'class'       => true,
					'fallback'    => true,
					'heights'     => true,
					'media'       => true,
					'noloading'   => true,
					'on'          => true,
					'placeholder' => true,
					'srcset'      => true,
					'sizes'       => true,
					'layout'      => true,
				) ),
				'amp-list' => array(
					'class'            => true,
					'credentials'      => true,
					'placeholder'      => true,
					'noloading'        => true,
					'on'               => true,
					'items'            => true,
					'max-items'        => true,
					'single-item'      => true,
					'reset-on-refresh' => true,
					'src'              => true,
					'[src]'            => true,
					'width'            => true,
					'height'           => true,
					'layout'           => true,
					'fallback'         => true,
				),
			);

			$allowed_tags = array_merge( $allowed_tags, $amp_tags );
		}
		return $allowed_tags;
	}
}
