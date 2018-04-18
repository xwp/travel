<?php
/**
 * Display rating for slim template.
 *
 * @package WPAMPTheme
 */

$rating = round( (int) get_post_meta( get_the_ID(), 'amp_travel_rating', true ) );
?>
<div class="inline-block relative mr1 h3 line-height-2">
	<div>
		<?php for ( $i = 0; $i < 5; $i++ ) : ?>
            <span class="travel-icon travel-img-icon-star-silver"></span>
		<?php endfor; ?>
	</div>
	<div class="absolute top-0">
		<?php for ( $i = 0; $i < $rating; $i++ ) : ?>
			<span class="travel-icon travel-img-icon-star-green"></span>
		<?php endfor; ?>
	</div>
</div>
