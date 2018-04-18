<?php
/**
 * Template for full Adventure post.
 *
 * @package WPAMPTheme
 */

?>
<h1 class="line-height-2 center product-title mb3"><?php echo esc_html( get_the_title() ); ?></h1>
<div class="lg-flex justify-between">
	<div class="product-details lg-col-2 mb1">
		<?php get_template_part( 'templates/entry/meta/location' ); ?>
		<div class="h4 line-height-2">
			<?php get_template_part( 'templates/entry/meta/reviews-count' ); ?>
			<?php get_template_part( 'templates/entry/meta/rating' ); ?>
		</div>
		<?php get_template_part( 'templates/social-share' ); ?>
	</div>
	<!-- / product-details -->

	<?php get_template_part( 'templates/entry/meta/cta' ); ?>

	<div class="product-main lg-col-7">

		<section class="product-content">
			<?php the_content(); ?>
		</section>

		<?php
		if ( comments_open() || wp_count_comments() ) :
			comments_template();
		endif;
		?>
	</div>
	<!-- / product-main -->

</div>
<!-- / lg-flex -->
