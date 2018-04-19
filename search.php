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
					<amp-live-list id="amp-travel-posts-list" class="live-list" data-poll-interval="<?php echo esc_attr( AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL ); ?>" data-max-items-per-page="<?php echo esc_attr( get_option( 'posts_per_page' ) ); ?>">
						<div update class="live-list__button">
							<button class="button" on="tap:amp-travel-posts-list.update"><?php esc_html_e( 'Load Newer Adventures', 'travel' ); ?></button>
						</div>
						<div items>
							<?php
							if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'templates/entry/slim' );
								endwhile;
							else :
								esc_html_e( 'No results found.', 'travel' );
							endif;
							?>
						</div>
						<div pagination></div>
					</amp-live-list>
				</div>
			</div>
		</section>
		<!--/ Results -->
	</div>
</div>

<?php get_footer(); ?>
