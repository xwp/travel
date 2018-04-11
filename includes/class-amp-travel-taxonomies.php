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
