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
			add_filter( 'rest_pre_echo_response', array( $this, 'filter_rest_pre_echo_response' ), 10, 3 );
			add_action( 'pre_get_posts', array( $this, 'filter_pre_get_posts' ), 10, 1 );
		}
	}

	/**
	 * Filters search to search adventures by from and to date.
	 *
	 * @param WP_Query $query Query.
	 */
	public function filter_pre_get_posts( $query ) {

		if ( ! is_admin() && is_search() ) {
			$meta_query  = array();
			$start_query = array();
			$end_query   = array();

			if ( ! empty( $_GET['start'] ) && ! empty( $_GET['end'] ) ) {
				$start       = esc_attr( $_GET['start'] );
				$end         = esc_attr( $_GET['end'] );
				$start_query = array(
					'relation' => 'OR',
					array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => $start,
								'compare' => '>=',
							),
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => '',
								'compare' => '=',
							),
						),
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => $end,
							'compare' => '<=',
						),
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => '',
							'compare' => '=',
						),
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => $start,
							'compare' => '>=',
						),
					),
				);

				// If we only have start date, only the end date is relevant.
			} elseif ( ! empty( $_GET['start'] ) ) {
				$start       = esc_attr( $_GET['start'] );
				$start_query = array(
					'relation' => 'OR',
					array(
						'key'     => 'amp_travel_end_date',
						'value'   => '',
						'compare' => '=',
					),
					array(
						'key'     => 'amp_travel_end_date',
						'value'   => $start,
						'compare' => '>=',
					),
				);
			} elseif ( ! empty( $_GET['end'] ) ) {
				$end       = esc_attr( $_GET['end'] );
				$end_query = array(
					'relation' => 'OR',
					array(
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'amp_travel_start_date',
								'value'   => '',
								'compare' => '=',
							),
							array(
								'key'     => 'amp_travel_end_date',
								'value'   => $end,
								'compare' => '<=',
							),
						),
						array(
							'key'     => 'amp_travel_start_date',
							'value'   => $end,
							'compare' => '<=',
						),
					),
					array(
						'relation' => 'AND',
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => $end,
							'compare' => '<=',
						),
						array(
							'key'     => 'amp_travel_end_date',
							'value'   => '',
							'compare' => '!=',
						),
					),
				);
			}

			if ( ! empty( $end_query ) && ! empty( $start_query ) ) {
				$meta_query = array(
					'relation' => 'AND',
					$start_query,
					$end_query,
				);
			} elseif ( ! empty( $start_query ) ) {
				$meta_query = $start_query;
			} elseif ( ! empty( $end_query ) ) {
				$meta_query = $end_query;
			}
		}
		if ( ! empty( $meta_query ) ) {
			$query->set( 'meta_query', $meta_query );
		}
	}

	/**
	 * Filters the rest_pre_echo_response for amp-list adventures.
	 *
	 * @param array           $result  Response data to send to the client.
	 * @param WP_REST_Server  $server  Server instance.
	 * @param WP_REST_Request $request Request used to generate the response.
	 * @return array
	 */
	public function filter_rest_pre_echo_response( $result, $server, $request ) {

		// Amp-list is processing JSON in a specific way, also requires items array.
		if ( false !== strpos( $request->get_route(), 'adventures' ) ) {
			$items = array(
				'items' => array(
					array(
						'adventures' => $result,
					),
				),
			);
			return $items;
		}
		return $result;
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
			array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
		);

		wp_localize_script(
			'travel-editor-blocks-js',
			'travelGlobals',
			array(
				'themeUrl' => esc_url( get_template_directory_uri() ),
				'siteUrl'  => site_url(),
				'apiUrl'   => get_rest_url(),
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
