<?php
/**
 * Display rating.
 *
 * @package WPAMPTheme
 */

$rating = round( (int) get_post_meta( get_the_ID(), 'amp_travel_rating', true ) );
?>
<div class="relative h2 line-height-2 mb1">
	<div class="travel-results-result-stars green">
		<div class="travel-results-results-stars-empty">★★★★★</div>
		<div class="travel-results-results-stars-solid">
			<?php echo esc_html( str_repeat( '★', $rating ) ); ?>
		</div>
	</div>
</div>
