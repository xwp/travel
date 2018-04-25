<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WPAMPTheme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function travel_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $template;
		if ( 'front-page.php' !== basename( $template ) ) {
			$classes[] = 'has-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'travel_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function travel_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'travel_pingback_header' );

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function travel_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'travel_filter_script_loader_tag', 10, 2 );

/**
 * Generate stylesheet URI.
 *
 * @param object $wp_styles Registered styles.
 * @param string $handle The style handle.
 */
function travel_get_preload_stylesheet_uri( $wp_styles, $handle ) {
	$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;
	return $preload_uri;
}

/**
 * Adds preload for in-body stylesheets depending on what templates are being used.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 */
function travel_add_body_style() {

	// Get the current template global.
	global $template;

	// Get registered styles.
	$wp_styles = wp_styles();

	$prelods = array();

	// Preload content.css.
	$preloads['travel-content'] = travel_get_preload_stylesheet_uri( $wp_styles, 'travel-content' );

	// Preload sidebar.css and widget.css.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$preloads['travel-sidebar'] = travel_get_preload_stylesheet_uri( $wp_styles, 'travel-sidebar' );
		$preloads['travel-widgets'] = travel_get_preload_stylesheet_uri( $wp_styles, 'travel-widgets' );
	}

	// Preload comments.css.
	if ( ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() ) ) {
		$preloads['travel-comments'] = travel_get_preload_stylesheet_uri( $wp_styles, 'travel-comments' );
	}

	// Preload front-page.css.
	if ( 'front-page.php' === basename( $template ) ) {
		$preloads['travel-front-page'] = travel_get_preload_stylesheet_uri( $wp_styles, 'travel-front-page' );
	}

	// Output the preload markup in <head>.
	foreach ( $preloads as $handle => $src ) {
		echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $src ) . '" as="style" />';
		echo "\n";
	}

}
add_action( 'wp_head', 'travel_add_body_style' );

/**
 * Display similar adventures.
 *
 * @return string Output.
 */
function amp_travel_render_similar_adventures() {
	$terms = wp_get_post_terms( get_the_ID(), 'location', array(
		'fields' => 'names',
	) );

	$adventures = get_posts(
		array(
			'post_type'   => 'adventure',
			'numberposts' => 3,
			'meta_key'    => '_thumbnail_id',
			'exclude'     => array( get_the_ID() ),
			'tax_query'   => array(
				array(
					'taxonomy' => 'location',
					'field'    => 'name',
					'terms'    => $terms,
				),
			),
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

	if ( count( $adventures ) !== AMP_Travel_Blocks::POPULAR_POSTS_COUNT ) {
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
					<div class="travel-overflow-wrap flex px1 md-px2 mxn1">';

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
		$reviews       = wp_count_comments( $adventure->ID );
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
		           sprintf( esc_html( _n( '%d Review', '%d Reviews', $reviews->approved, 'travel' ) ), esc_html( $reviews->approved ) ) . '</span>
				<span class="travel-results-result-subtext"><svg class="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg>
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
	} elseif ( is_search() ) {
		wp_enqueue_style( 'amp_travel_search', get_template_directory_uri() . '/assets/css/search.css' );
	} elseif ( is_archive() ) {
		wp_enqueue_style( 'amp_travel_archive', get_template_directory_uri() . '/assets/css/archive.css' );
	} else {
		wp_enqueue_style( 'amp_travel_homepage', get_template_directory_uri() . '/assets/css/homepage.css' );
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
		/* translators: %d: Rating */
		echo '<option value="' . esc_attr( $i ) . '">' . sprintf( esc_html( _n( '%d star', '%d stars', $i, 'travel' ) ), esc_html( number_format_i18n( $i ) ) ) . '</option>';
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
	if ( ! get_comment() ) {
		return $text;
	}
	$rating = get_comment_meta( get_comment_ID(), 'rating', true );
	if ( $rating ) {
		$rating_html = '<div class="comment-review relative h3 line-height-2">
							<div  class="travel-results-result-stars green">';

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

/**
 * Add AMP states.
 */
function amp_travel_states() {
	?>
	<?php if ( is_singular( 'adventure' ) ) : ?>
		<amp-state id="adventure_price"><script type="application/json"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></script></amp-state>
		<amp-state id="adventure_current_price"><script type="application/json"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></script></amp-state>
	<?php else : ?>
		<amp-state id="search_query">
			<script type="application/json">
				{
					"search": ""
				}
			</script>
		</amp-state>

		<amp-state id="fields_query"><script type="application/json">""</script></amp-state>
		<amp-state id="fields_query_initial"><script type="application/json">""</script></amp-state>

		<?php if ( is_search() ) : ?>
			<amp-state id="fields_query_live"><script type="application/json"><?php echo isset( $_GET['s'] ) ? sprintf( '"%s"', esc_html( $_GET['s'] ) ) : '""'; ?></script></amp-state>
			<amp-state id="query_query"><script type="application/json"><?php echo isset( $_GET['s'] ) ? sprintf( '"%s"', esc_html( $_GET['s'] ) ) : '""'; ?></script></amp-state>

			<amp-state id="fields_start"><script type="application/json"><?php echo isset( $_GET['start'] ) ? sprintf( '"%s"', esc_html( $_GET['start'] ) ) : '""'; ?></script></amp-state>
			<amp-state id="fields_end"><script type="application/json"><?php echo isset( $_GET['end'] ) ? sprintf( '"%s"', esc_html( $_GET['end'] ) ) : '""'; ?></script></amp-state>
		<?php endif; ?>
	<?php
	endif;
}
add_action( 'wp_footer', 'amp_travel_states' );

/**
 * Put together current search URL for search.php link.
 *
 * @return string
 */
function amp_travel_get_current_search_url() {
	$url        = site_url() . '?s=' . sanitize_text_field( wp_unslash( $_GET['s'] ) );
	$start_date = ! empty( $_GET['start'] ) ? sanitize_text_field( wp_unslash( $_GET['start'] ) ) : '';
	$end_date   = ! empty( $_GET['end'] ) ? sanitize_text_field( wp_unslash( $_GET['end'] ) ) : '';

	if ( ! empty( $start_date ) ) {
		$url .= '&start=' . $start_date;
	}
	if ( ! empty( $end_date ) ) {
		$url .= '&end=' . $end_date;
	}

	return $url;
}
