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
			<amp-img class="rounded bg-silver mb1" width="2" height="1" noloading="" layout="responsive" src="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>" ></amp-img>
		</a>
	</div>
	<div class="h2 line-height-2 mb1">
		<span class="travel-results-result-text"><?php echo get_the_title(); ?></span>
		<?php get_template_part( 'templates/entry/meta/price' ); ?>
	</div>
	<?php get_template_part( 'templates/entry/meta/slim-meta' ); ?>
</div>
