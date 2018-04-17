<?php
/**
 * Template for full Adventure post.
 *
 * @package WPAMPTheme
 */

?>
<h1 class="line-height-2 center product-title mb3"><?php echo esc_html( get_the_title() ); ?></h1>
<div class="lg-flex justify-between">
	<div class="product-details lg-col-2">
		<div class="h4 line-height-2">
			<?php get_template_part( 'templates/entry/meta/location' ); ?>
			<?php get_template_part( 'templates/entry/meta/reviews-count' ); ?>
			<?php get_template_part( 'templates/entry/meta/rating' ); ?>
			<?php get_template_part( 'templates/social-share' ); ?>
		</div>
	</div>
	<!-- / product-details -->

	<div class="product-cta lg-col-2 lg-right-align">
		<h4 class="product-cta-title mb2 line-height-1">$<?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></h4>

		<select class="select-arr mb1 rounded" name="count">
			<?php for ( $i = 2; $i <= 8; $i += 2 ) : ?>
				<?php /* translators: %d: The number of people */ ?>
				<option value="<?php echo esc_html( $i ); ?>"><?php echo sprintf( esc_html__( 'For %d', 'travel' ), esc_html( $i ) ); ?></option>
			<?php endfor; ?>
		</select>

		<a href="#" class="product-cta-btn ampstart-btn rounded center bold white block col-12"><?php esc_html_e( 'Call to book' ); ?></a>
	</div>
	<!-- / product-cta -->

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
