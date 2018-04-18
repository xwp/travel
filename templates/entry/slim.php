<?php
/**
 * Slim entry template.
 *
 * @package WPAMPTheme
 */

$locations = wp_get_post_terms( get_the_ID(), 'location', array(
	'fields' => 'names',
) );
$location  = ! empty( $locations ) ? $locations[0] : '--';
$reviews   = wp_count_comments( get_the_ID() );
?>

<div class="col-12 sm-col-6 lg-col-4 p1 travel-results-result" style="float:left;">
	<div class="relative travel-results-result">
		<a class="travel-results-result-link" href="<?php the_permalink(); ?>">
			<amp-img class="rounded bg-silver mb1" width="2" height="1" noloading="" layout="responsive" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" ></amp-img>
		</a>
	</div>
	<div class="h2 line-height-2 mb1">
		<span class="travel-results-result-text"><?php echo get_the_title(); ?></span>
		<span class="travel-results-result-subtext h3">&bull;</span>
		<span class="travel-results-result-subtext h3">$&nbsp;</span>
		<span class="bold"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></span>
	</div>
	<div class="h4 line-height-2">
		<?php get_template_part( 'templates/entry/meta/slim-rating' ); ?>
		<?php /* translators: %d: Number of reviews. */ ?>
		<span class="travel-results-result-subtext mr1"><?php printf( esc_html__( '%d Reviews', 'travel' ), esc_html( $reviews->approved ) ); ?></span>
		<span class="nowrap">
            <span class="travel-icon travel-img-icon-map-pin-outline-gray"></span>
			<?php esc_html_e( $location ); ?>
        </span>
	</div>
</div>
