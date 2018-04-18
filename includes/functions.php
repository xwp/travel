<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

define( 'AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL', 15000 );

/**
 * Init theme.
 *
 * @return object Theme object
 */
function amp_travel_theme() {
	return AMP_Travel_Theme::get_instance();
}

/**
 * Display similar adventures.
 *
 * @return string Output.
 */
function amp_travel_render_similar_adventures() {
	$terms = wp_get_post_terms( null, 'location', array(
		'fields' => 'names',
	) );

	$adventures = get_posts(
		array(
			'post_type'   => 'adventure',
			'numberposts' => 3,
			'meta_key'    => '_thumbnail_id',
			'tax_query'   => array(
				array(
					'taxonomy' => 'location',
					'field'    => 'slug',
					'terms'    => $terms,
				),
			),
			'exclude'     => array( get_the_ID() ),
		)
	);

	$args = array(
		'heading' => __( 'Similar Adventures', 'travel' ),
	);

	return amp_travel_get_popular_adventures( $adventures, $args );
}

/**
 * Get HTML for popular adventures.
 *
 * @param array $adventures Adventures.
 * @param array $attributes Attributes.
 * @return string HTML.
 */
function amp_travel_get_popular_adventures( $adventures, $attributes ) {
	$output = '';

	if ( count( $adventures ) !== AMP_Travel_Blocks::$popular_posts_count ) {
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
 * Enqueues styles.
 */
function amp_travel_enqueue_styles() {
	if ( is_singular( 'adventure' ) ) {
		wp_enqueue_style( 'amp_travel_adventure', get_template_directory_uri() . '/assets/css/adventure.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'amp_travel_enqueue_styles' );

/**
 * Add rating field to comments.
 */
function amp_travel_comment_rating_field() {
	echo '<p class="comment-form-rating"><label for="rating">' . esc_html( 'Your rating' ) . '</label>
			<select required="required" class="select-arr rounded" name="rating" id="rating" [disabled]="commentform_post_' . esc_attr( get_the_ID() ) . '.submitting" on=\'change:AMP.setState( { commentform_post_' . esc_attr( get_the_ID() ) . ': { values: { "rating": event.value } } } )\'>
			<option value="">--</option>';

	for ( $i = 5; $i >= 1; $i-- ) {
		echo '<option value="' . esc_attr( $i ) . '">' . sprintf( '%d star(s)', esc_attr( $i ) ) . '</option>';
	}
	echo '</select>
		</p>';
}
add_action( 'comment_form_logged_in_after', 'amp_travel_comment_rating_field' );
add_action( 'comment_form_after_fields', 'amp_travel_comment_rating_field' );

/**
 * Save custom fields meta.
 *
 * @param integer $comment_id Comment ID.
 */
function amp_travel_save_comment_meta_data( $comment_id ) {

	$comment = get_comment( $comment_id );
	if ( current_user_can( 'unfiltered_html' ) ) {
		if ( ! isset( $_POST['_wp_unfiltered_html_comment'] )
			|| ! wp_verify_nonce( $_POST['_wp_unfiltered_html_comment'], 'unfiltered-html-comment_' . $comment->comment_post_ID )
		) {
			kses_remove_filters(); // Start with a clean slate.
			kses_init_filters(); // Set up the filters.
		}
	}

	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) ) {
		$rating = absint( wp_filter_nohtml_kses( $_POST['rating'] ) );
		add_comment_meta( $comment_id, 'rating', $rating );
	}
}
add_action( 'comment_post', 'amp_travel_save_comment_meta_data' );

/**
 * Update adventure rating.
 *
 * @param integer $comment_id Comment ID.
 */
function amp_travel_update_adventure_rating( $comment_id ) {
	$comment = get_comment( $comment_id );
	$post    = get_post( $comment->comment_post_ID );

	if ( AMP_Travel_CPT::POST_TYPE_SLUG_SINGLE === $post->post_type ) {
		$rating = amp_travel_calculate_adventure_rating( $post->ID );
		update_post_meta( $post->ID, 'amp_travel_rating', $rating );
	}
}

/**
 * Update rating on comment status transition if it was approved before
 *
 * @param string     $new_status New status.
 * @param string     $old_status Old status.
 * @param WP_Comment $comment Comment.
 */
function amp_travel_transition_comment_status( $new_status, $old_status, $comment ) {
	if ( 'approved' === $old_status || 'approved' === $new_status ) {
		amp_travel_update_adventure_rating( $comment->comment_ID );
	}
}

// Update rating when a comment is inserted.
add_action( 'wp_insert_comment', 'amp_travel_update_adventure_rating', 10, 1 );
add_action( 'transition_comment_status', 'amp_travel_transition_comment_status', 10, 3 );

/**
 * Calculate average rating for adventure.
 *
 * @param integer $adventure_id Adventure ID.
 * @return float|int|string
 */
function amp_travel_calculate_adventure_rating( $adventure_id = null ) {
	if ( ! $adventure_id ) {
		$adventure_id = get_the_ID();
	}

	$approved_comments = get_approved_comments( $adventure_id );
	$rating            = 0;
	$divider           = count( $approved_comments );

	foreach ( $approved_comments as $comment ) {
		$comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
		if ( $comment_rating ) {
			$rating += $comment_rating;
		} else {
			$divider--;
		}
	}

	if ( 0 === $divider || 0 === $rating ) {
		return '';
	}

	return $rating / $divider;
}

/**
 * Display rating in the comment.
 *
 * @param string $text Comment's content.
 * @return string
 */
function amp_travel_modify_comment_display( $text ) {
	$rating = get_comment_meta( get_comment_ID(), 'rating', true );
	if ( $rating ) {
		$rating_html = '<div style="width:100%;" class="inline-block relative h3 line-height-2">
							<div class="travel-results-result-stars green">';

		for ( $i = 0; $i < round( $rating ); $i++ ) {
			$rating_html .= '★';
		}
		$rating_html .= '</div></div>';
		$text         = $rating_html . $text;
		return $text;
	} else {
		return $text;
	}
}
add_filter( 'comment_text', 'amp_travel_modify_comment_display' );
