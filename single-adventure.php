<?php
/**
 * Template for Travel Adventure Custom Post Type.
 *
 * @package WPAMPTheme
 */

get_header();
?>
<?php get_template_part( 'templates/gallery-hero' ); ?>

<!-- Product Wrap -->
<div class="product-wrap pb4 pt3 relative">
	<div class="max-width-3 mx-auto px1 md-px2">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				get_template_part( 'templates/entry/full' );
			endwhile;
		endif;
		?>

	</div>
</div>
<!-- / Product Wrap -->

<div id="travel-landing-content" class="travel-landing-content relative">

	<div class="travel-footer-wrapper">
		<?php get_template_part( 'templates/footer-search' ); ?>
		<?php get_template_part( 'templates/similar-adventures' ); ?>
	</div>
</div>
<?php get_footer(); ?>
