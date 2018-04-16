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
			add_action( 'init', array( $this, 'register_block_activity_list' ) );
			add_action( 'init', array( $this, 'register_block_discover' ) );
			add_action( 'pre_get_posts', array( $this, 'filter_search_pre_get_posts' ) );
		}
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

		return amp_travel_get_popular_adventures( $adventures, $attributes );
	}

	/**
	 * Register Travel Activity List block type.
	 */
	public function register_block_activity_list() {
		register_block_type( 'amp-travel/activity-list', array(
			'attributes'      => array(
				'heading' => array(
					'type'    => 'string',
					'default' => __( 'Browse by Activity', 'travel' ),
				),
			),
			'render_callback' => array( $this, 'render_block_activity_list' ),
		) );
	}

	/**
	 * Front-side render for Travel Activity List block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string Output.
	 */
	public function render_block_activity_list( $attributes ) {
		$activities = get_terms( array(
			'taxonomy'   => 'activity',
			'hide_empty' => false,
		) );

		if ( empty( $activities ) ) {
			return '';
		}

		if ( ! empty( $attributes['heading'] ) ) {
			$heading = $attributes['heading'];
		} else {
			$heading = false;
		}

		$output = "<section class='travel-activities pb4 pt3 relative'>";
		if ( $heading ) {
			$output .= "<div class='max-width-3 mx-auto px1 md-px2'>
						<h3 class='bold h1 line-height-2 mb2 md-hide lg-hide' aria-hidden='true'>" . esc_attr( $heading ) . "</h3>
						<h3 class='bold h1 line-height-2 mb2 xs-hide sm-hide center'>" . esc_attr( $heading ) . '</h3>
					</div>';
		}
		$output .= "<div class='overflow-scroll'>
						<div class='travel-overflow-container'>
							<div class='flex justify-center p1 md-px1 mxn1'>";

		foreach ( $activities as $activity ) {
			$output .= "<a href='" . get_term_link( $activity ) . "' class='travel-activities-activity travel-type-" . $activity->slug . " mx1'>
									<div class='travel-shadow circle inline-block'>
										<div class='travel-activities-activity-icon'>";
			$output .= get_term_meta( $activity->term_id, 'amp_travel_activity_svg', true );

			$output .= "</div>
						</div>
						<p class='bold center line-height-4'>" . esc_attr( $activity->name ) . '</p>
						</a>';
		}

		$output .= '</div>
						</div>
					</div>
				</section>';
		return $output;

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
	 * Modify the default search query to include 'adventure' post type.
	 *
	 * @param object $query Original query.
	 */
	public function filter_search_pre_get_posts( $query ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', array( 'post', 'adventure' ) );
		}
	}

	/**
	 * Register Travel Discover block type.
	 */
	public function register_block_discover() {
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
			'render_callback' => array( $this, 'render_block_discover' ),
		) );
	}

	/**
	 * Front-side render for Travel Discover block.
	 *
	 * @param array $attributes Block attributes.
	 * @return string Output.
	 */
	public function render_block_discover( $attributes ) {
		global $post;

		$args = array(
			'numberposts' => 1,
			'post_status' => 'publish',
			'post_type'   => 'post',
		);

		if ( $post ) {
			$args['exclude'] = array( $post->ID );
		}

		$posts = wp_get_recent_posts( $args );

		$heading    = $attributes['heading'];
		$subheading = $attributes['subheading'];

		// If there's no post, return.
		if ( empty( $posts ) ) {
			return '';
		}

		$discover_post = $posts[0];
		$title         = get_the_title( $discover_post['ID'] );
		$link          = get_permalink( $discover_post['ID'] );

		// Use the wp_trim_words directly since otherwise the_content will run endlessly due to wp_trim_excerpt() using the global post.
		if ( empty( $discover_post['post_excerpt'] ) ) {

			/** This filter is documented in wp-includes/formatting.php */
			$excerpt_length = apply_filters( 'excerpt_length', 15 );
			/** This filter is documented in wp-includes/formatting.php */
			$excerpt_more = apply_filters( 'excerpt_more', ' ...' );
			$excerpt      = wp_trim_words( $discover_post['post_content'], $excerpt_length, $excerpt_more );
		} else {
			$excerpt = get_the_excerpt( $discover_post['ID'] );
		}

		$output = '<section class="travel-discover py4 mb3 relative xs-hide sm-hide">
				<div class="max-width-3 mx-auto px1 md-px2">
					<div class="flex justify-between items-center">
						<header>
							<h2 class="travel-discover-heading bold line-height-2 xs-hide sm-hide">' . esc_html( $heading ) . '</h2>
							<div class="travel-discover-subheading h2 xs-hide sm-hide">' . esc_html( $subheading ) . '</div>
						</header>
						<div class="travel-discover-panel travel-shadow-hover px3 py2 ml1 mr3 myn3 xs-hide sm-hide">
							<div class="bold h2 line-height-2 my1">' . esc_html( $title ) . '</div>
							<p class="travel-discover-panel-subheading h3 my1 line-height-2">
								' . esc_html( $excerpt ) . '
							</p>
							<p class="my1">
								<a class="travel-link" href=" ' . esc_url( $link ) . '">' . esc_html__( 'Read more', 'travel' ) . '</a>
							</p>
						</div>
					</div>
				</div>
			</section>';

		return $output;
	}

}
