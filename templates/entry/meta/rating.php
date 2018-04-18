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
		<?php for ( $i = 0; $i < $rating; $i++ ) : ?>
			★
		<?php endfor; ?>
	</div>
</div>
