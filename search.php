<?php
/**
 * Search template.
 *
 * @package WPAMPTheme
 */

get_header();
?>
<div class="travel-overlay-fx-scale">
	<div class="travel-no-focus flex-auto overflow-auto" role="button" tabindex="-1">

		<!-- Results -->
		<section class="travel-results pb1 md-pt1">
			<div class="travel-inline-list travel-results-list">
				<div class="max-width-3 mx-auto px1 md-px2">
					<?php if ( isset( $_GET['s'] ) ) : ?>
						<?php /* translators: %d: Number of results; %s: Search phrase. */ ?>
						<h1><?php printf( esc_html( _n( '%d Result for ', '%d Results for ', amp_travel_get_posts_count(), 'travel' ) ) . '<strong>%s</strong>', esc_html( amp_travel_get_posts_count() ), esc_html( $_GET['s'] ) ); ?></h1>
					<?php endif; ?>
					<?php get_template_part( 'templates/live-lists/posts' ); ?>
				</div>
			</div>
		</section>
		<!--/ Results -->
	</div>
</div>

<?php get_footer(); ?>
