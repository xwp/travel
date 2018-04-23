<?php
/**
 * Template for displaying archive.
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
					<?php get_template_part( 'templates/live-lists/posts' ); ?>
				</div>
			</div>
		</section>
		<!--/ Results -->
	</div>
</div>

<?php get_footer(); ?>
