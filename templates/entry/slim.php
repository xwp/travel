<?php
/**
 * Slim entry template.
 *
 * @package WPAMPTheme
 */

?>
<div id="<?php echo esc_attr( get_the_ID() ); ?>-post" data-sort-time="<?php echo esc_attr( get_the_date( 'U' ) ); ?>" class="col-12 sm-col-6 lg-col-4 p1 travel-results-result">
	<div class="relative travel-results-result">
		<a class="travel-results-result-link" href="<?php the_permalink(); ?>">
			<?php
				$image_data   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'travel-600x300' );
				$image_url    = $image_data[0];
				$image_width  = $image_data[1];
				$image_height = $image_data[2];
			?>
			<amp-img class="rounded bg-silver mb1" width="<?php echo esc_attr( $image_width ); ?>" height="<?php echo esc_attr( $image_height ); ?>" noloading="" layout="responsive" src="<?php echo esc_url( $image_url ); ?>"></amp-img>
		</a>
	</div>
	<div class="h2 line-height-2 mb1">
		<span class="travel-results-result-text"><?php echo get_the_title(); ?></span>
		<?php get_template_part( 'templates/entry/meta/price' ); ?>
	</div>
	<?php get_template_part( 'templates/entry/meta/slim-meta' ); ?>
</div>
