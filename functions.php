<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

/**
 * Enqueue JS for block editor only.
 */
function amp_travel_enqueue_editor_scripts() {

	// If Gutenberg doesn't exist, don't load any scripts.
	if ( ! function_exists( 'gutenberg_init' ) ) {
		return;
	}

	// Enqueue JS bundled file.
	wp_enqueue_script(
		'travel-editor-blocks-js',
		get_template_directory_uri() . '/assets/js/editor-blocks.js',
		array( 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components', 'wp-api' )
	);

	// This will be needed for featured block for the sample image URLs.
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

// Hook into block editor assets.
add_action( 'enqueue_block_editor_assets', 'amp_travel_enqueue_editor_scripts' );

/**
 * Replaces data-amp-bind-* with [*].
 * This is a workaround for React considering some AMP attributes (e.g. [src]) invalid.
 *
 * @param string $content Content.
 * @return mixed
 */
function amp_travel_filter_the_content_amp_atts( $content ) {
	if ( ! function_exists( 'gutenberg_init' ) ) {
		return $content;
	}

	return preg_replace( '/\sdata-amp-bind-(.+?)=/', ' [$1]=', $content );
}

add_filter( 'the_content', 'amp_travel_filter_the_content_amp_atts', 10, 1 );

/**
 * Front-side render for Travel Activity List block.
 *
 * @param array $attributes Block attributes.
 * @return string Output.
 */
function amp_travel_render_block_travel_activity_list( $attributes ) {
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
		$output .= "<a href='" . get_term_link( $activity ) . "' class='travel-activities-activity travel-type-active mx1'>
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
 * Register Travel Activity List block type.
 */
function amp_travel_register_block_travel_discover() {
	if ( function_exists( 'register_block_type' ) ) {
		register_block_type( 'amp-travel/activity-list', array(
			'attributes'      => array(
				'heading' => array(
					'type'    => 'string',
					'default' => __( 'Browse by Activity', 'travel' ),
				),
			),
			'render_callback' => 'amp_travel_render_block_travel_activity_list',
		) );
	}
}
add_action( 'init', 'amp_travel_register_block_travel_discover' );

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
