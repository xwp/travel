<?php
/**
 * Display meta for slim template.
 *
 * @package WPAMPTheme
 */


$locations = wp_get_post_terms( get_the_ID(), 'location', array(
	'fields' => 'names',
) );
$location  = ! empty( $locations ) ? $locations[0] : '--';
$reviews   = wp_count_comments( get_the_ID() );
?>
<div class="h4 line-height-2">
	<?php get_template_part( 'templates/entry/meta/slim-rating' ); ?>
	<?php /* translators: %d: Number of reviews. */ ?>
	<span class="travel-results-result-subtext mr1"><?php printf( esc_html__( '%d Reviews', 'travel' ), esc_html( $reviews->approved ) ); ?></span>
	<span class="nowrap slim-location">
		<span class="travel-icon travel-img-icon-map-pin-outline-gray"></span>
		<?php echo esc_html( $location ); ?>
	</span>
</div>
