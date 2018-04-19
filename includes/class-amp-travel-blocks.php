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
	const FEATURED_LOCATIONS_COUNT = 6;

	/**
	 * Number of popular posts to display.
	 *
	 * @var int
	 */
	const POPULAR_POSTS_COUNT = 3;

	/**
	 * Init Travel Blocks.
	 */
	public function init() {
		if ( function_exists( 'gutenberg_init' ) ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_editor_scripts' ) );
			add_filter( 'the_content', array( $this, 'filter_the_content_amp_atts' ), 10, 1 );
			add_filter( 'wp_kses_allowed_html', array( $this, 'filter_wp_kses_allowed_html' ), 10, 2 );
			add_action( 'init', array( $this, 'register_block_travel_featured' ) );
			add_action( 'init', array( $this, 'register_block_travel_popular' ) );
			add_action( 'init', array( $this, 'register_block_activity_list' ) );
			add_action( 'init', array( $this, 'register_block_discover' ) );
			add_filter( 'rest_pre_echo_response', array( $this, 'filter_rest_pre_echo_response' ), 10, 3 );
			add_action( 'pre_get_posts', array( $this, 'filter_pre_get_posts' ), 10, 1 );

			// Filters for featured block.
			add_filter( 'rest_location_query', array( $this, 'filter_rest_featured_location_query' ), 10, 2 );
			add_filter( 'rest_post_dispatch', array( $this, 'filter_rest_featured_post_response' ), 10, 3 );
			add_filter( 'rest_prepare_location', array( $this, 'add_featured_location_rest_data' ), 10, 3 );
		}
	}

	/**
	 * Filters search to search adventures by from and to date.
	 *
	 * @param WP_Query $query Query.
	 */
	public function filter_pre_get_posts( $query ) {

		if ( ! is_admin() && is_search() ) {
			$meta_query = array();

			if ( ! empty( $_GET['start'] ) && ! empty( $_GET['end'] ) ) {
				$start      = sanitize_text_field( wp_unslash( $_GET['start'] ) );
				$end        = sanitize_text_field( wp_unslash( $_GET['end'] ) );
				$meta_query = array(
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
				$start      = sanitize_text_field( wp_unslash( $_GET['start'] ) );
				$meta_query = array(
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
				$end        = sanitize_text_field( wp_unslash( $_GET['end'] ) );
				$meta_query = array(
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

		// Make sure that request is from AMP.
		$amp_origin = $request->get_param( '__amp_source_origin' );
		if ( empty( $amp_origin ) ) {
			return $result;
		}

		// Amp-list is processing JSON in a specific way, also requires items array.
		if ( false !== strpos( $request->get_route(), 'adventures' ) ) {
			return array(
				'items' => array(
					array(
						'adventures' => $result,
					),
				),
			);
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
				'post_type'   => AMP_TRAVEL_CPT::POST_TYPE_SLUG_SINGLE,
				'numberposts' => self::POPULAR_POSTS_COUNT,
				'orderby'     => 'meta_value_num',
				'meta_key'    => 'amp_travel_rating',
			)
		);

		if ( count( $adventures ) !== self::POPULAR_POSTS_COUNT ) {
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

		$output = '<section id="travel-discover" class="travel-discover py4 mb3 relative">
				<div class="max-width-3 mx-auto px1 md-px2">
					<div class="flex justify-between items-center">
						<header>
							<h2 class="travel-discover-heading bold line-height-2 xs-hide sm-hide">' . esc_html( $heading ) . '</h2>
							<div class="travel-discover-subheading h2 xs-hide sm-hide">' . esc_html( $subheading ) . '</div>
						</header>
						<div class="travel-discover-panel travel-shadow-hover px3 py2 ml1 mr3 myn3">
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
		$locations = get_terms( array(
			'taxonomy'   => 'location',
			'meta_key'   => AMP_Travel_Taxonomies::LOCATION_FEATURED_META_FIELD,
			'meta_value' => 1,
			'number'     => self::FEATURED_LOCATIONS_COUNT,
			'hide_empty' => false,
		) );

		// The count has to be 6 to fill the grid.
		if ( count( $locations ) !== self::FEATURED_LOCATIONS_COUNT ) {
			return '';
		}

		// Sort the terms and get back sorted term arrays.
		$locations = $this->sort_terms_for_featured_grid( $locations );

		// Check again the count, if some image is missing, it won't be 6.
		if ( count( $locations ) !== self::FEATURED_LOCATIONS_COUNT ) {
			return '';
		}

		$output = '<section class="travel-featured pt3 relative clearfix">
						<header class="max-width-2 mx-auto px1 md-px2 relative">
							<h3 class="travel-featured-heading h1 bold line-height-2 mb2 center">' . esc_html( $attributes['heading'] ) . '</h3>
						</header>
						<div class="max-width-3 mx-auto relative">
						<div class="travel-featured-grid flex flex-wrap items-stretch">';

		// Each grid slot has specific attributes.
		$location_params = array(
			array(
				'width'  => 336,
				'height' => 507,
				'color'  => 'blue',
			),
			array(
				'width'  => 264,
				'height' => 246,
				'color'  => 'cyan',
			),
			array(
				'width'  => 264,
				'height' => 264,
				'color'  => 'orange',
			),
			array(
				'width'  => 276,
				'height' => 207,
				'color'  => 'purple',
			),
			array(
				'width'  => 264,
				'height' => 286,
				'color'  => 'cornflower',
			),
			array(
				'width'  => 312,
				'height' => 507,
				'color'  => 'teal',
			),
		);

		foreach ( $locations as $i => $location ) {

			// Start of the first half-grid.
			if ( 0 === $i ) {
				$output .= '<div class="col-12 md-col-6 flex items-stretch flex-auto">';

				// Start of the second column of the first half-grid.
			} elseif ( 1 === $i ) {
				$output .= '<div class="flex flex-column items-stretch flex-auto">';
			} elseif ( 3 === $i ) {

				// Start of the second half-grid and third column.
				$output .= '<div class="col-12 md-col-6 flex items-stretch flex-auto">
						<div class="flex flex-column items-stretch flex-auto">';
			}

			$location_img_id     = get_term_meta( $location['term_id'], AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD, true );
			$location_img_src    = wp_get_attachment_image_src( $location_img_id, 'full' );
			$location_img_srcset = wp_get_attachment_image_srcset( $location_img_id, 'full' );

			$output .= '<a href="' . esc_url( get_term_link( $location['term_id'] ) ) . '" class="travel-featured-tile flex flex-auto relative travel-featured-color-' .
							esc_attr( $location_params[ $i ]['color'] ) . '">
							<amp-img class="travel-object-cover flex-auto" layout="responsive" width="' .
							esc_attr( $location_params[ $i ]['width'] ) . '" height="' .
							esc_attr( $location_params[ $i ]['height'] ) . '" srcset="' . esc_attr( $location_img_srcset ) . '" src="' . esc_url( $location_img_src[0] ) . '""></amp-img>
							<div class="travel-featured-overlay absolute z1 center top-0 right-0 bottom-0 left-0 white p2">
								<div class="travel-featured-tile-heading caps bold line-height-2 h3">' . esc_html( $location['name'] ) . '</div>
								<div class="h5">' .
								/* translators: %d: The count of posts of term. */
								sprintf( esc_html__( '%d adventures', 'travel' ), esc_html( $location['count'] ) ) . '</div>
							</div>
						</a>';

			if ( 2 === $i ) {

				// End of the first half + end of the second column of the grid.
				$output .= '</div></div>';
			} elseif ( 4 === $i || 5 === $i ) {

				// End of the third column / End of the second half-grid.
				$output .= '</div>';
			}
		}

		$output .= '</div>
				</div>
			</section>';

		return $output;
	}
	/**
	 * Filter REST location query to filter by featured posts.
	 *
	 * @param array           $args Query args.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function filter_rest_featured_location_query( $args, $request ) {
		$meta_key   = $request->get_param( 'meta_key' );
		$meta_value = $request->get_param( 'meta_value' );

		if ( AMP_Travel_Taxonomies::LOCATION_FEATURED_META_FIELD === $meta_key && null !== $meta_value ) {
			$args['meta_key']   = $meta_key;
			$args['meta_value'] = (bool) $meta_value;
		}
		return $args;
	}

	/**
	 * Add location image links to REST response.
	 *
	 * @param WP_REST_Response $response Response.
	 * @param WP_Term          $location Term object.
	 * @param WP_REST_Request  $request Request.
	 * @return mixed
	 */
	public function add_featured_location_rest_data( $response, $location, $request ) {
		$data = $response->get_data();

		if ( 'view' !== $request['context'] || is_wp_error( $response ) ) {
			return $response;
		}

		$location_img_id = get_term_meta( $location->term_id, AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD, true );

		if ( ! $location_img_id ) {
			return $response;
		}

		$location_img_src = wp_get_attachment_image_src( $location_img_id, 'full' );
		if ( empty( $location_img_src ) ) {
			return $response;
		}

		$meta = array(
			AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD => $location_img_src[0],
		);

		if ( ! isset( $data['meta'] ) ) {
			$data['meta'] = $meta;
		} else {
			$data['meta'] = array_merge( $data['meta'], $meta );
		}

		$response->set_data( $data );

		return $response;
	}

	/**
	 * Sort featured terms for the grid.
	 *
	 * @param array $terms Array of terms.
	 * @return array
	 */
	public function sort_terms_for_featured_grid( $terms ) {
		$portrait_slots  = array( 0, 4, 5 );
		$landscape_slots = array( 1, 2, 3 );
		$sorted_terms    = array();

		foreach ( $terms as $term ) {

			// If the input might be as objects as well.
			if ( ! is_array( $term ) ) {
				$term = (array) $term;

				if ( ! isset( $term['meta'][ AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD ] ) ) {
					$term['meta'][ AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD ] = get_term_meta( $term['term_id'], AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD, true );
				}
			}

			if ( empty( $term['meta'][ AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD ] ) ) {
				continue;
			}

			$term_image = wp_get_attachment_metadata( $term['meta'][ AMP_Travel_Taxonomies::LOCATION_IMG_META_FIELD ] );

			// If it's portrait, first try to fill portrait slots.
			if ( $term_image['height'] > $term_image['width'] ) {
				if ( ! empty( $portrait_slots ) ) {
					$sorted_terms[ $portrait_slots[0] ] = $term;
					array_shift( $portrait_slots );
				} elseif ( ! empty( $landscape_slots ) ) {
					$sorted_terms[ $landscape_slots[0] ] = $term;
					array_shift( $landscape_slots );
				}

				// If it's landscape, first try to fill landscape slots.
			} else {
				if ( ! empty( $landscape_slots ) ) {
					$sorted_terms[ $landscape_slots[0] ] = $term;
					array_shift( $landscape_slots );
				} elseif ( ! empty( $portrait_slots ) ) {
					$sorted_terms[ $portrait_slots[0] ] = $term;
					array_shift( $portrait_slots );
				}
			}
		}
		ksort( $sorted_terms );
		return $sorted_terms;

	}

	/**
	 * Filter locations response to sort the terms.
	 *
	 * @param WP_REST_Response $response Response.
	 * @param WP_REST_Server   $server REST Server.
	 * @param WP_REST_Request  $request Request.
	 * @return mixed
	 */
	public function filter_rest_featured_post_response( $response, $server, $request ) {
		if ( '/wp/v2/' . AMP_Travel_Taxonomies::LOCATION_TERM !== $request->get_route() ) {
			return $response;
		}

		$data = $response->get_data();
		if ( empty( $data ) || count( $data ) !== self::FEATURED_LOCATIONS_COUNT ) {
			return $response;
		}

		$sorted_terms = $this->sort_terms_for_featured_grid( $data );

		if ( ! empty( $sorted_terms ) ) {
			$response->set_data( $sorted_terms );
		}

		return $response;
	}
}
