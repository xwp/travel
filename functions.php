<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

// Include required classes.
require_once get_template_directory() . '/includes/class-amp-travel-blocks.php';


if ( ! function_exists( 'travel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WPAMPTheme, use a find and replace
		 * to change 'travel' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel', get_template_directory() . '/languages' );

		add_theme_support( 'amp', array() );

		// Init blocks.
		new AMP_Travel_Blocks();
	}
endif;

// Hook into theme after setup.
add_action( 'after_setup_theme', 'travel_setup' );

/**
 * Register Travel theme taxonomies.
 */
function amp_travel_register_taxonomies() {
	register_taxonomy( 'activity', 'post', array(
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
}
add_action( 'init', 'amp_travel_register_taxonomies' );

/**
 * Register activity meta.
 */
function amp_travel_register_activity_svg() {
	$args = array(
		'sanitize_callback' => 'amp_travel_sanitize_activity_svg',
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
	);
	register_meta( 'term', 'amp_travel_activity_svg', $args );
}
add_action( 'init', 'amp_travel_register_activity_svg' );

/**
 * Sanitize the SVG field.
 *
 * @param string $text Text.
 * @return string
 */
function amp_travel_sanitize_activity_svg( $text ) {
	$allowed_html = array(
		'path' => array(
			'fill' => true,
			'd'    => true,
		),
		'svg'  => array(
			'class'   => true,
			'viewbox' => true,
		),
	);

	// Replace ' with " since ' might cause issues with sanitizing.
	$text = trim( str_replace( "'", '"', $text ) );
	return wp_kses( $text, $allowed_html );
}

/**
 * Add metafield to Add Activity form page.
 */
function amp_travel_add_activity_meta_fields() {
	?>
	<div class='form-field form-required term-svg-wrap'>
		<label for='travel-activity-svg'>SVG</label>
		<?php wp_nonce_field( basename( __FILE__ ), 'travel_activity_svg_nonce' ); ?>
		<textarea aria-required='true' name='travel-activity-svg' id='travel-activity-svg'></textarea>
		<p class="description"><?php esc_attr_e( 'This is for the background icon of the activity term.', 'travel' ); ?></p>
	</div>
<?php
}
add_action( 'activity_add_form_fields', 'amp_travel_add_activity_meta_fields' );

/**
 * Add SVG field to Activity term edit view.
 *
 * @param WP_Term $term Term object.
 */
function amp_travel_edit_activity_meta_fields( $term ) {
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
				<?php
				// @codingStandardsIgnoreLine
				echo amp_travel_sanitize_activity_svg( $value );
				?>
			</textarea>
			<p class="description"><?php esc_attr_e( 'This is for the background icon of the activity term.', 'travel' ); ?></p>
		</td>
	</tr>
<?php
}
add_action( 'activity_edit_form_fields', 'amp_travel_edit_activity_meta_fields' );

/**
 * Save Activity SVG value on adding and editing the term.
 *
 * @param integer $term_id Term ID.
 */
function amp_travel_save_activity_svg( $term_id ) {

	if ( ! wp_verify_nonce( $_POST['travel_activity_svg_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	$old_value = get_term_meta( $term_id, 'amp_travel_activity_svg', true );
	$new_value = isset( $_POST['travel-activity-svg'] ) ? amp_travel_sanitize_activity_svg( $_POST['travel-activity-svg'] ) : '';
	if ( $old_value !== $new_value ) {
		update_term_meta( $term_id, 'amp_travel_activity_svg', $new_value );
	}
}
add_action( 'edit_activity', 'amp_travel_save_activity_svg' );
add_action( 'create_activity', 'amp_travel_save_activity_svg' );
