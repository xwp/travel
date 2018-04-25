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
	 * Location term.
	 *
	 * @var string
	 */
	const LOCATION_TERM = 'location';

	/**
	 * Location cover img meta field.
	 *
	 * @var string
	 */
	const LOCATION_IMG_META_FIELD = 'amp_travel_location_img';

	/**
	 * Location featured meta field.
	 *
	 * @var bool
	 */
	const LOCATION_FEATURED_META_FIELD = 'amp_travel_featured';

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

		add_action( 'location_add_form_fields', array( $this, 'add_location_meta_fields' ) );
		add_action( 'location_edit_form_fields', array( $this, 'edit_location_meta_fields' ) );
		add_action( 'edit_location', array( $this, 'save_location_meta' ) );
		add_action( 'create_location', array( $this, 'save_location_meta' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Enqueue admin scripts.
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $_GET['taxonomy'] ) || 'location' !== $_GET['taxonomy'] ) {
			return;
		}
		wp_enqueue_media();

		wp_enqueue_script(
			'amp-travel-term-controls',
			get_template_directory_uri() . '/assets/js/term-controls.js',
			array( 'jquery', 'underscore', 'wp-i18n' )
		);
	}

	/**
	 * Add location meta fields to add form.
	 */
	public function add_location_meta_fields() {
		?>
		<div class='form-field form-required location-cover-image-wrap'>
			<?php wp_nonce_field( basename( __FILE__ ), 'travel_location_meta_nonce' ); ?>
			<label for='location-cover-image'><?php esc_html_e( 'Activity Cover Image' ); ?></label>
			<input type='hidden' id='location-cover-image-value' class='small-text' name='location-cover-image-value' value='' />
			<input type='button' id='location-cover-image' class='button location-cover-image-upload-button' value='<?php esc_html_e( 'Select' ); ?>' />
			<input type='button' id='location-cover-image-remove' class='button location-cover-image-upload-button-remove hidden' value='<?php esc_html_e( 'Remove' ); ?>' />
			<div id='location-cover-image-preview'></div>
		</div>
		<div class='form-field location-is-featured-wrap'>
			<label for='location-is-featured'><?php esc_html_e( 'Featured destination' ); ?></label>
			<input type='checkbox' name='location-is-featured' value='1' />
		</div>
		<?php
	}

	/**
	 * Add meta fields to term edit.
	 *
	 * @param WP_Term $term WP_Term being edited.
	 */
	public function edit_location_meta_fields( $term ) {
		$cover_img_id = get_term_meta( $term->term_id, self::LOCATION_IMG_META_FIELD, true );
		if ( empty( $cover_img_id ) ) {
			$cover_img_id = '';
		} else {
			$img_src = wp_get_attachment_image_src( $cover_img_id );
		}

		$is_featured = get_term_meta( $term->term_id, self::LOCATION_FEATURED_META_FIELD, true );

		?>
		<tr class='form-field form-required location-cover-image-wrap'>
			<th scope="row"><label for='location-cover-image'><?php esc_html_e( 'Activity Cover Image' ); ?></label></th>
			<td>
				<?php wp_nonce_field( basename( __FILE__ ), 'travel_location_meta_nonce' ); ?>

				<input type='hidden' id='location-cover-image-value' class='small-text' name='location-cover-image-value' value='<?php echo esc_attr( $cover_img_id ); ?>' />
				<input type='button' id='location-cover-image' class='button location-cover-image-upload-button' value='<?php esc_html_e( 'Upload' ); ?>' />
				<input type='button' id='location-cover-image-remove' class='button location-cover-image-upload-button-remove' value='<?php esc_html_e( 'Remove' ); ?>' />
				<div id='location-cover-image-preview'><?php echo empty( $img_src ) ? '' : '<img src="' . esc_url( $img_src[0] ) . '" style="max-width: 100%;" />'; ?></div>
			</td>
		</tr>
		<tr class='form-field form-required'>
			<th scope='row'><label for='location-is-featured'><?php esc_html_e( 'Featured destination' ); ?></label></th>
			<td>
				<input type='checkbox' name='location-is-featured' value='1' <?php echo $is_featured ? esc_html( 'checked' ) : ''; ?> />
			</td>
		</tr>
		<?php
	}

	/**
	 * Save Location meta values on adding and editing the term.
	 *
	 * @param integer $term_id Term ID.
	 */
	public function save_location_meta( $term_id ) {
		if ( ! wp_verify_nonce( $_POST['travel_location_meta_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$old_img_value = get_term_meta( $term_id, self::LOCATION_IMG_META_FIELD, true );
		$new_img_value = isset( $_POST['location-cover-image-value'] ) ? sanitize_text_field( absint( $_POST['location-cover-image-value'] ) ) : '';
		if ( $old_img_value !== $new_img_value ) {
			update_term_meta( $term_id, self::LOCATION_IMG_META_FIELD, $new_img_value );
		}

		$old_is_featured_value = get_term_meta( $term_id, self::LOCATION_FEATURED_META_FIELD, true );
		$new_is_featured_value = isset( $_POST['location-is-featured'] ) ? sanitize_text_field( absint( $_POST['location-is-featured'] ) ) : 0;
		if ( $old_is_featured_value !== $new_is_featured_value ) {
			update_term_meta( $term_id, self::LOCATION_FEATURED_META_FIELD, $new_is_featured_value );
		}
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
			<textarea aria-required='true' name='travel_activity_svg' id='travel-activity-svg'></textarea>
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
				<textarea aria-required="true" name="travel_activity_svg" id="travel-activity-svg"><?php echo $this->sanitize_activity_svg( $value ); // WPCS: XSS ok. ?></textarea>
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
		$vars = array(
			'travel_activity_svg'       => 'FILTER_UNSAFE_RAW',
			'travel_activity_svg_nonce' => 'FILTER_SANITIZE_STRING',
		);

		$data = filter_input_array( INPUT_POST, $vars );

		if ( ! wp_verify_nonce( $data['travel_activity_svg_nonce'], basename( __FILE__ ) ) ) {
			return;
		}

		$old_value      = get_term_meta( $term_id, 'amp_travel_activity_svg', true );
		$original_value = isset( $data['travel_activity_svg'] ) ? trim( $data['travel_activity_svg'] ) : '';
		$new_value      = isset( $data['travel_activity_svg'] ) ? $this->sanitize_activity_svg( $data['travel_activity_svg'] ) : '';

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
