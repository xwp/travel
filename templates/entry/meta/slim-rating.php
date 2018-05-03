<?php
/**
 * Display rating for slim template.
 *
 * @package WPAMPTheme
 */

$rating = round( (int) get_post_meta( get_the_ID(), 'amp_travel_rating', true ) );

if ( empty( $rating ) ) {
	return;
}
?>
<div class="inline-block relative mr1 h3 line-height-2">
	<div>
		<div class="travel-results-results-stars-empty-small">★★★★★</div>
	</div>
	<div class="travel-results-results-stars-solid-small">
		<?php echo esc_html( str_repeat( '★', $rating ) ); ?>
	</div>
</div>
