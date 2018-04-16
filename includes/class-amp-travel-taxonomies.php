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
	 * Init AMP_Travel_Taxonomies.
	 */
	public function init() {
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_activity_meta' ) );
		add_action( 'activity_add_form_fields', array( $this, 'add_activity_meta_fields' ) );
		add_action( 'activity_edit_form_fields', array( $this, 'edit_activity_meta_fields' ) );
		add_action( 'edit_activity', array( $this, 'save_activity_meta' ) );
		add_action( 'create_activity', array( $this, 'save_activity_meta' ) );
	}

	/**
	 * Register Activity meta.
	 */
	public function register_activity_meta() {
		$args = array(
			'sanitize_callback' => array( $this, 'sanitize_activity_svg' ),
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
		);
		register_meta( 'term', 'amp_travel_activity_svg', $args );
	}

	/**
	 * Add metafield to Add Activity form page.
	 */
	public function add_activity_meta_fields() {
		?>
		<div class='form-field form-required term-svg-wrap'>
			<label for='travel-activity-svg'>SVG</label>
			<?php wp_nonce_field( basename( __FILE__ ), 'travel_activity_svg_nonce' ); ?>
			<textarea aria-required='true' name='travel-activity-svg' id='travel-activity-svg'></textarea>
			<p class="description"><?php esc_html_e( 'This is for the background icon of the activity term. Only <path>, <svg>, <g>, and <circle> elements are allowed', 'travel' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Sanitize the SVG field.
	 *
	 * @param string $text Text.
	 * @return string
	 */
	public function sanitize_activity_svg( $text ) {
		$allowed_html = array(
			'path'   => array(
				'fill'         => true,
				'd'            => true,
				'id'           => true,
				'stroke'       => true,
				'stroke-width' => true,
			),
			'svg'    => array(
				'class'   => true,
				'viewbox' => true,
				'height'  => true,
				'width'   => true,
			),
			'g'      => array(
				'fill'         => true,
				'fill-rule'    => true,
				'stroke'       => true,
				'stroke-width' => true,
			),
			'circle' => array(
				'cx'           => true,
				'cy'           => true,
				'r'            => true,
				'stroke'       => true,
				'stroke-width' => true,
			),
		);

		// Replace ' with " since ' might cause issues with sanitizing.
		$text = trim( str_replace( "'", '"', $text ) );
		return wp_kses( $text, $allowed_html );
	}

	/**
	 * Add SVG field to Activity term edit view.
	 *
	 * @param WP_Term $term Term object.
	 */
	public function edit_activity_meta_fields( $term ) {
		$value = get_term_meta( $term->term_id, 'amp_travel_activity_svg', true );
		if ( empty( $value ) ) {
			$value = '';
		}
		?>
		<tr class="form-field term-svg-wrap">
			<th scope="row"><label for="travel-activity-svg"><?php esc_attr_e( 'SVG', 'travel' ); ?></label></th>
			<td>
				<?php wp_nonce_field( basename( __FILE__ ), 'travel_activity_svg_nonce' ); ?>
				<textarea aria-required="true" name="travel-activity-svg" id="travel-activity-svg">
				<?php echo $this->sanitize_activity_svg( $value ); // WPCS: XSS ok. ?>
			</textarea>
				<p class="description"><?php esc_html_e( 'This is for the background icon of the activity term. Only <path>, <svg>, <g>, and <circle> elements are allowed', 'travel' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Save Activity SVG value on adding and editing the term.
	 *
	 * @param integer $term_id Term ID.
	 */
	public function save_activity_meta( $term_id ) {

		if ( ! wp_verify_nonce( $_POST['travel_activity_svg_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$old_value      = get_term_meta( $term_id, 'amp_travel_activity_svg', true );
		$original_value = isset( $_POST['travel-activity-svg'] ) ? trim( $_POST['travel-activity-svg'] ) : '';
		$new_value      = isset( $_POST['travel-activity-svg'] ) ? $this->sanitize_activity_svg( $_POST['travel-activity-svg'] ) : '';

		if ( $old_value !== $new_value ) {

			// If the stripped new value is completely empty but the intended value was not, don't save it.
			if ( '' === $new_value && '' !== $original_value ) {
				return;
			}
			update_term_meta( $term_id, 'amp_travel_activity_svg', $new_value );
		}
	}

	/**
	 * Register 'activity' and 'location' taxonomy.
	 */
	public function register_taxonomies() {
		register_taxonomy( 'activity', array( AMP_TRAVEL_CPT::POST_TYPE_SLUG_SINGLE, 'post' ), array(
			'query_var'             => 'activity',
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

		register_taxonomy( 'location', array( AMP_TRAVEL_CPT::POST_TYPE_SLUG_SINGLE, 'post' ), array(
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
