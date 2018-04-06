<?php
/**
 * Class for Travel taxonomies.
 *
 * @package WPAMPTheme
 */

/**
 * Class Travel_Taxonomies
 *
 * @package WPAMPTheme
 */
class AMP_Travel_Taxonomies {

	/**
	 * AMP_Travel_Taxonomies constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_amp_travel_location_img' ) );
		add_action( 'init', array( $this, 'register_block_travel_featured' ) );
		add_filter( 'rest_location_query', array( $this, 'filter_rest_location_query' ), 10, 2 );
	}

	/**
	 * Filter REST location query to filter by featured posts.
	 *
	 * @param array           $args Query args.
	 * @param WP_REST_Request $request Request object.
	 * @return mixed
	 */
	public function filter_rest_location_query( $args, $request ) {
		$meta_key   = $request->get_param( 'meta_key' );
		$meta_value = $request->get_param( 'meta_value' );

		if ( 'amp_travel_featured' === $meta_key && null !== $meta_value ) {
			$args['meta_key']   = $meta_key;
			$args['meta_value'] = (bool) $meta_value;
		}
		return $args;
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
			'per_page'   => 6,
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

	/**
	 * Register Location term image meta.
	 *
	 * @todo Register actual image field for the form. Also, we'll need to
	 * @todo know it's measures to know if it's landscape or portrait, so perhaps save it as an ID.
	 */
	public function register_amp_travel_location_img() {
		$args = array(
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
		);
		register_meta( 'term', 'amp_travel_location_img', $args );
	}

	/**
	 * Register 'activity' and 'location' taxonomy.
	 */
	public function register_taxonomies() {
		register_taxonomy( 'activity', array( 'adventure', 'post' ), array(
			'hierarchical'          => false,
			'query_var'             => 'activity',
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_rest'          => true,
			'rest_base'             => 'activities',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'labels'                => array(
				'name'                       => __( 'Activities', 'travel' ),
				'singular_name'              => __( 'Activity', 'travel' ),
				'search_items'               => __( 'Search Activities', 'travel' ),
				'popular_items'              => __( 'Popular Activities', 'travel' ),
				'all_items'                  => __( 'All Activities', 'travel' ),
				'edit_item'                  => __( 'Edit Activity', 'travel' ),
				'view_item'                  => __( 'View Activity', 'travel' ),
				'update_item'                => __( 'Update Activity', 'travel' ),
				'add_new_item'               => __( 'Add New Activity', 'travel' ),
				'new_item_name'              => __( 'New Activity Name', 'travel' ),
				'separate_items_with_commas' => __( 'Separate activities with commas', 'travel' ),
				'add_or_remove_items'        => __( 'Add or remove activities', 'travel' ),
				'choose_from_most_used'      => __( 'Choose from the most used activities', 'travel' ),
				'not_found'                  => __( 'No activities found.', 'travel' ),
				'no_terms'                   => __( 'No activities', 'travel' ),
				'items_list_navigation'      => __( 'Activities list navigation', 'travel' ),
				'items_list'                 => __( 'Activities list', 'travel' ),
				'most_used'                  => __( 'Most Used', 'travel' ),
				'back_to_items'              => __( '&larr; Back to Activities', 'travel' ),
			),
		) );

		register_taxonomy( 'location', array( 'adventure', 'post' ), array(
			'hierarchical'          => false,
			'query_var'             => 'location',
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_rest'          => true,
			'rest_base'             => 'locations',
			'rest_controller_class' => 'WP_REST_Terms_Controller',
			'labels'                => array(
				'name'                       => __( 'Locations', 'travel' ),
				'singular_name'              => __( 'Location', 'travel' ),
				'search_items'               => __( 'Search Locations', 'travel' ),
				'popular_items'              => __( 'Popular Locations', 'travel' ),
				'all_items'                  => __( 'All Locations', 'travel' ),
				'edit_item'                  => __( 'Edit Location', 'travel' ),
				'view_item'                  => __( 'View Location', 'travel' ),
				'update_item'                => __( 'Update Location', 'travel' ),
				'add_new_item'               => __( 'Add New Location', 'travel' ),
				'new_item_name'              => __( 'New Location Name', 'travel' ),
				'separate_items_with_commas' => __( 'Separate locations with commas', 'travel' ),
				'add_or_remove_items'        => __( 'Add or remove locations', 'travel' ),
				'choose_from_most_used'      => __( 'Choose from the most used locations', 'travel' ),
				'not_found'                  => __( 'No locations found.', 'travel' ),
				'no_terms'                   => __( 'No locations', 'travel' ),
				'items_list_navigation'      => __( 'Locations list navigation', 'travel' ),
				'items_list'                 => __( 'Locations list', 'travel' ),
				'most_used'                  => __( 'Most Used', 'travel' ),
				'back_to_items'              => __( '&larr; Back to Locations', 'travel' ),
			),
		) );
	}
}

new AMP_Travel_Taxonomies();
