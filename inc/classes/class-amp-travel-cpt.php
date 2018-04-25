<?php
/**
 * Class for Travel Custom Post Type.
 *
 * @package WPAMPTheme
 */

/**
 * Class AMP_Travel_CPT
 *
 * @package WPAMPTheme
 */
class AMP_Travel_CPT {

	/**
	 * The post type single slug.
	 *
	 * @var string
	 */
	const POST_TYPE_SLUG_SINGLE = 'adventure';

	/**
	 * The post type plural slug.
	 *
	 * @var string
	 */
	const POST_TYPE_SLUG_PLURAL = 'adventures';

	/**
	 * Initialize the CPT class.
	 */
	public function init() {
		add_action( 'init', array( $this, 'setup' ) );
		add_action( 'add_meta_boxes_adventure', array( $this, 'add_adventure_meta_boxes' ) );
		add_action( 'save_post_adventure', array( $this, 'save_adventure_post' ) );
		add_filter( 'rest_prepare_adventure', array( $this, 'add_adventure_rest_data' ), 10, 3 );

		add_filter( 'rest_adventure_collection_params', array( $this, 'filter_rest_adventure_collection_params' ), 10, 1 );
		add_filter( 'rest_adventure_query', array( $this, 'filter_rest_adventure_query' ), 10, 2 );
	}

	/**
	 * Setup the Custom post type support.
	 */
	public function setup() {
		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register the post type.
		$this->register_post_type();

		// Register adventure mta.
		$this->register_meta();
	}

	/**
	 * Register Adventure meta.
	 */
	private function register_meta() {
		$args = array(
			'sanitize_callback' => 'sanitize_attr',
			'type'              => 'integer',
			'description'       => __( 'Adventure Price', 'travel' ),
			'single'            => true,
			'show_in_rest'      => true,
		);
		register_meta( 'post', 'amp_travel_price', $args );
	}

	/**
	 * Add adventure meta.
	 *
	 * @param WP_REST_Response $response Response.
	 * @param WP_POST          $adventure Adventure post.
	 * @param WP_REST_Request  $request Request.
	 * @return mixed
	 */
	public function add_adventure_rest_data( $response, $adventure, $request ) {
		$data = $response->get_data();

		if ( 'view' !== $request['context'] || is_wp_error( $response ) ) {
			return $response;
		}

		$price   = get_post_meta( $adventure->ID, 'amp_travel_price', true );
		$rating  = round( (int) get_post_meta( $adventure->ID, 'amp_travel_rating', true ) );
		$reviews = wp_count_comments( $adventure->ID );
		$terms   = wp_get_post_terms( $adventure->ID, 'location', array(
			'fields' => 'names',
		) );

		if ( ! empty( $terms ) ) {
			$location = $terms[0];
		} else {
			$location = '--';
		}

		$meta = array(
			'amp_travel_price'    => $price,
			'amp_travel_rating'   => $rating,
			'amp_travel_reviews'  => $reviews->approved,
			'amp_travel_location' => $location,
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
	 * Register 'adventure' post type.
	 */
	private function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Adventures', 'Post type general name', 'travel' ),
			'singular_name'         => _x( 'Adventure', 'Post type singular name', 'travel' ),
			'menu_name'             => _x( 'Adventures', 'Admin Menu text', 'travel' ),
			'name_admin_bar'        => _x( 'Adventure', 'Add New on Toolbar', 'travel' ),
			'add_new'               => __( 'Add New', 'travel' ),
			'add_new_item'          => __( 'Add New Adventure', 'travel' ),
			'new_item'              => __( 'New Adventure', 'travel' ),
			'edit_item'             => __( 'Edit Adventure', 'travel' ),
			'view_item'             => __( 'View Adventure', 'travel' ),
			'all_items'             => __( 'All Adventures', 'travel' ),
			'search_items'          => __( 'Search Adventures', 'travel' ),
			'parent_item_colon'     => __( 'Parent Adventures:', 'travel' ),
			'not_found'             => __( 'No adventures found.', 'travel' ),
			'not_found_in_trash'    => __( 'No adventures found in Trash.', 'travel' ),
			'featured_image'        => _x( 'Adventure Cover Image', 'Overrides the “Featured Image” phrase for this post type.', 'travel' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type.', 'travel' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type.', 'travel' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type.', 'travel' ),
			'archives'              => _x( 'Adventure archives', 'The post type archive label used in nav menus. Default “Post Archives”.', 'travel' ),
			'insert_into_item'      => _x( 'Insert into adventure', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', 'travel' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this adventure', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post).', 'travel' ),
			'filter_items_list'     => _x( 'Filter adventures list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', 'travel' ),
			'items_list_navigation' => _x( 'Adventures list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', 'travel' ),
			'items_list'            => _x( 'Adventures list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', 'travel' ),
		);

		$args = array(
			'labels'        => $labels,
			'description'   => __( 'Adventure Custom Post Type for travel theme.', 'travel' ),
			'public'        => true,
			'menu_position' => 20,
			'menu_icon'     => 'dashicons-location-alt',
			'supports'      => array(
				'title',
				'editor',
				'thumbnail',
				'comments',
			),
			'has_archive'   => true,
			'rewrite'       => array(
				'slug' => self::POST_TYPE_SLUG_SINGLE,
			),
			'show_in_rest'  => true,
			'rest_base'     => self::POST_TYPE_SLUG_PLURAL,
		);

		register_post_type( self::POST_TYPE_SLUG_SINGLE, $args );
	}

	/**
	 * Adds meta boxes for adventure post type.
	 */
	public function add_adventure_meta_boxes() {
		add_meta_box( 'amp_travel_adventure_meta', __( 'Adventure details', 'travel' ), array( $this, 'adventure_meta_box_html' ), 'adventure', 'side' );
	}

	/**
	 * Displays meta boxes in admin.
	 */
	public function adventure_meta_box_html() {
		$adventure_custom = get_post_custom();
		$price            = isset( $adventure_custom['amp_travel_price'][0] ) ? $adventure_custom['amp_travel_price'][0] : '';
		$start_date       = isset( $adventure_custom['amp_travel_start_date'][0] ) ? $adventure_custom['amp_travel_start_date'][0] : '';
		$end_date         = isset( $adventure_custom['amp_travel_end_date'][0] ) ? $adventure_custom['amp_travel_end_date'][0] : '';
		?>
		<div>
			<label for='amp_travel_start_date'><?php esc_html_e( 'Start date', 'travel' ); ?></label><input placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' type='date' id='amp_travel_start_date' name='amp_travel_start_date' value='<?php echo esc_attr( $start_date ); ?>'>
		</div>
		<div>
			<label for='amp_travel_end_date'><?php esc_html_e( 'Ending date', 'travel' ); ?></label><input placeholder='yyyy-mm-dd' pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' type='date' id='amp_travel_end_date' name='amp_travel_end_date' value='<?php echo esc_attr( $end_date ); ?>'>
		</div>
		<?php wp_nonce_field( basename( __FILE__ ), 'amp_travel_adventure_nonce' ); ?>
		<p class='description'><?php esc_html_e( 'Leave empty if the adventure is ongoing', 'travel' ); ?></p>

		<label for='amp_travel_price'><?php esc_html_e( 'Price (USD)', 'travel' ); ?></label>
		<input id='amp_travel_price' name='amp_travel_price' value='<?php echo esc_attr( $price ); ?>'>
		<?php
	}

	/**
	 * Saves the custom meta.
	 */
	public function save_adventure_post() {
		$vars = array(
			'amp_travel_start_date'      => 'FILTER_SANITIZE_STRING',
			'amp_travel_end_date'        => 'FILTER_SANITIZE_STRING',
			'amp_travel_price'           => 'FILTER_SANITIZE_STRING',
			'amp_travel_adventure_nonce' => 'FILTER_SANITIZE_STRING',
		);

		$data = wp_unslash( filter_input_array( INPUT_POST, $vars ) );

		// This check is needed since otherwise Gutenberg save will fail -- it uses different saving logic.
		if (
			isset( $data['amp_travel_start_date'] )
			||
			isset( $data['amp_travel_end_date'] )
			||
			isset( $data['amp_travel_price'] )
		) {
			global $post;

			if ( ! wp_verify_nonce( $data['amp_travel_adventure_nonce'], basename( __FILE__ ) ) ) {
				return;
			}

			if ( isset( $data['amp_travel_price'] ) ) {
				update_post_meta( get_the_ID(), 'amp_travel_price', sanitize_text_field( $data['amp_travel_price'] ) );
			}

			if ( isset( $data['amp_travel_start_date'] ) ) {
				update_post_meta( $post->ID, 'amp_travel_start_date', sanitize_text_field( $data['amp_travel_start_date'] ) );
			}

			if ( isset( $data['amp_travel_end_date'] ) ) {
				update_post_meta( $post->ID, 'amp_travel_end_date', sanitize_text_field( $data['amp_travel_end_date'] ) );
			}
		}
	}

	/**
	 * Change query args to include meta_key and meta_type.
	 *
	 * @param array           $args Query args.
	 * @param WP_REST_Request $request Request object.
	 * @return array
	 */
	public function filter_rest_adventure_query( $args, $request ) {
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
	 * @param array $query_params Collection params.
	 * @return array Collection params.
	 */
	public function filter_rest_adventure_collection_params( $query_params ) {
		$query_params['orderby']['enum'][] = 'meta_value_num';
		$query_params['meta_key']          = array(
			'description'       => __( 'The meta key to query.', 'travel' ),
			'type'              => 'string',
			'enum'              => array( 'amp_travel_rating' ),
			'validate_callback' => 'rest_validate_request_arg',
		);
		return $query_params;
	}
}
