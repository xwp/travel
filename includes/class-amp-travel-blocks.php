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
	 * Required count for featured locations block.
	 *
	 * @var int
	 */
	public static $featured_locations_count = 6;

	/**
	 * AMP_Travel_Blocks constructor.
	 */
	public function __construct() {
		if ( function_exists( 'gutenberg_init' ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
			add_filter( 'the_content', array( $this, 'filter_the_content_amp_atts' ), 10, 1 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );
			add_action( 'init', array( $this, 'register_block_travel_featured' ) );
		}
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

	/**
	 * Register Travel theme Featured block.
	 */
	public function register_block_travel_featured() {
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type( 'amp-travel/featured', array(
				'attributes'      => array(
					'heading' => array(
						'type'    => 'string',
						'default' => __( 'Featured destinations', 'travel' ),
					),
				),
				'render_callback' => array( $this, 'render_block_travel_featured' ),
			) );
		}
	}

	/**
	 * Frontside render for Featured block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string Output.
	 */
	public function render_block_travel_featured( $attributes ) {

		// @todo Featured meta doesn't exist yet actually.
		$locations = get_terms( array(
			'taxonomy'   => 'location',
			'meta_key'   => 'amp_travel_featured',
			'meta_value' => true,
			'per_page'   => self::$featured_locations_count,
		) );

		// The count has to be 6 to fill the grid.
		if ( 6 !== count( $locations ) ) {
			return '';
		}

		// @todo Create the output for the section.
		$output = "<section className='travel-featured pt3 relative clearfix'>
						<header className='max-width-2 mx-auto px1 md-px2 relative'>
							<h3 class='travel-featured-heading h1 bold line-height-2 mb2 center'>" . esc_attr( $attributes['heading'] ) . '</h3>
						</header>
					</section>';
		return $output;
	}
}

new AMP_Travel_Blocks();