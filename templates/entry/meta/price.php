<?php
/**
 * Display price meta for slim template.
 *
 * @package WPAMPTheme
 */

$price = get_post_meta( get_the_ID(), 'amp_travel_price', true );

if ( empty( $price ) ) {
	return;
}
?>
<span class="travel-results-result-subtext h3">&bull;</span>
<span class="travel-results-result-subtext h3">$&nbsp;</span><span class="bold"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></span>
