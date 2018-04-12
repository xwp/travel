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
	 * Number of popular posts to display.
	 *
	 * @var int
	 */
	public static $popular_posts_count = 3;

	/**
	 * Init Travel Blocks.
	 */
	public function init() {
		if ( function_exists( 'gutenberg_init' ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
			add_filter( 'the_content', array( $this, 'filter_the_content_amp_atts' ), 10, 1 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );

			add_action( 'init', array( $this, 'register_block_travel_popular' ) );
		}
	}

	/**
	 * Frontend render for Popular block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string Output.
	 */
	public function render_block_travel_popular( $attributes ) {
		$output = '';

		$adventures = get_posts(
			array(
				'post_type'   => 'adventure',
				'numberposts' => self::$popular_posts_count,
				'orderby'     => 'meta_value_num',
				'meta_key'    => 'amp_travel_rating',
			)
		);

		if ( count( $adventures ) !== self::$popular_posts_count ) {
			return $output;
		}

		$output .= '<section class="travel-popular pb4 pt3 relative">';

		if ( ! empty( $attributes['heading'] ) ) {
			$output .= '<header class="max-width-3 mx-auto px1 md-px2">
				<h3 class="h1 bold line-height-2 md-hide lg-hide" aria-hidden="true">' . esc_html( $attributes['heading'] ) . '</h3>
				<h3 class="h1 bold line-height-2 xs-hide sm-hide center">' . esc_html( $attributes['heading'] ) . '</h3>
			</header>';
		}

		$output .= '<div class="overflow-scroll">
				<div class="travel-overflow-container">
					<div class="flex px1 md-px2 mxn1">';

		$popular_classes = array(
			'travel-popular-tilt-right',
			'travel-results-result',
			'travel-popular-tilt-left',
		);

		foreach ( $adventures as $index => $adventure ) {
			$attachment_id = get_post_thumbnail_id( $adventure->ID );
			$img_src       = wp_get_attachment_image_url( $attachment_id, 'full' );
			$img_srcset    = wp_get_attachment_image_srcset( $attachment_id );
			$price         = get_post_meta( $adventure->ID, 'amp_travel_price', true );
			$rating        = round( (int) get_post_meta( $adventure->ID, 'amp_travel_rating', true ) );
			$comments      = wp_count_comments( $adventure->ID );
			$locations     = wp_get_post_terms( $adventure->ID, 'location', array(
				'fields' => 'names',
			) );

			if ( is_wp_error( $locations ) || empty( $locations ) ) {
				$location = '--';
			} else {
				$location = $locations[0];
			}

			$output .= '<div class="m1 mt3 mb2"><div class="' . esc_html( $popular_classes[ $index ] ) . ' mb1">
								<div class="relative travel-results-result">
									<a class="travel-results-result-link block relative" href="' . esc_url( get_the_permalink( $adventure->ID ) ) . '">
										<amp-img class="block rounded" width="346" height="200" noloading="" src="' . esc_url( $img_src ) . '" srcset="' . esc_attr( $img_srcset ) . '"></amp-img>
									</a>
								</div>
							</div>
							<div class="h2 line-height-2 mb1">
								<span class="travel-results-result-text">' . esc_html( get_the_title( $adventure->ID ) ) . '</span>
								<span class="travel-results-result-subtext h3">•</span>
								<span class="travel-results-result-subtext h3">$&nbsp;</span><span class="black bold">' . esc_html( $price ) . '</span>
							</div>
							<div class="h4 line-height-2">
								<div class="inline-block relative mr1 h3 line-height-2">
									<div class="travel-results-result-stars green">';

			for ( $i = 0; $i < $rating; $i++ ) {
				$output .= '★';
			}

			$output .= '</div>
							</div>
							<span class="travel-results-result-subtext mr1">' .
								/* translators: %d: The number of reviews */
								sprintf( esc_html__( '%d Reviews', 'travel' ), esc_html( $comments->approved ) ) . '</span>
							<span class="travel-results-result-subtext"><svg class="travel-icon" viewBox="0 0 77 100"><g fill="none" fillRule="evenodd"><path stroke="currentColor" strokeWidth="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg>
							' . esc_html( $location ) . '</span>
						</div>
						</div>';

		}

		$output .= '</div>
				</div>
			</div>
		</section>';

		return $output;
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
			array( 'underscore', 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
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
