<?php
/**
 * Display live posts lists.
 *
 * @package WPAMPTheme
 */

?>
<amp-live-list id="amp-travel-posts-list" class="live-list" data-poll-interval="<?php echo esc_attr( AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL ); ?>" data-max-items-per-page="<?php echo esc_attr( get_option( 'posts_per_page' ) ); ?>">
	<div update class="live-list__button">
		<button class="button" on="tap:amp-travel-posts-list.update"><?php esc_html_e( 'Load Newer Adventures', 'travel' ); ?></button>
	</div>
	<div class="flex flex-wrap mxn1 flex-auto" items>
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
