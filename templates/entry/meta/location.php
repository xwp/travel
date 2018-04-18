<?php
/**
 * Display location.
 *
 * @package WPAMPTheme
 */

$locations = wp_get_post_terms( get_the_ID(), 'location', array(
	'fields' => 'names',
) );
$location  = ! empty( $locations ) ? $locations[0] : '--';
?>
<div class="h4 line-height-2">
	<p class="travel-results-result-subtext mb1">
		<svg class="travel-icon" viewBox="0 0 77 100"><g fill="none" fill-rule="evenodd"><path stroke="currentColor" stroke-width="7.5" d="M38.794 93.248C58.264 67.825 68 49.692 68 38.848 68 22.365 54.57 9 38 9S8 22.364 8 38.85c0 10.842 9.735 28.975 29.206 54.398a1 1 0 0 0 1.588 0z"></path><circle cx="38" cy="39" r="10" fill="currentColor"></circle></g></svg>
		<?php echo esc_html( $location ); ?>
	</p>
</div>
