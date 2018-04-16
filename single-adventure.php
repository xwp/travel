<?php
/**
 * Template for Travel Adventure Custom Post Type.
 *
 * @package WPAMPTheme
 */

get_header();
?>

<!-- CAROUSEL -->
<h1>TODO: Carousel</h1>

<!-- Product Wrap -->
<div class="product-wrap pb4 pt3 relative">
	<div class="max-width-3 mx-auto px1 md-px2">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				$attachment_id = get_post_thumbnail_id();
				$img_src       = wp_get_attachment_image_url( $attachment_id, 'full' );
				$img_srcset    = wp_get_attachment_image_srcset( $attachment_id );
				$price         = get_post_meta( get_the_ID(), 'amp_travel_price', true );
				$rating        = round( (int) get_post_meta( get_the_ID(), 'amp_travel_rating', true ) );
				$comments      = wp_count_comments();
				$locations     = wp_get_post_terms( null, 'location', array(
					'fields' => 'names',
				) );
				$location      = ! empty( $locations ) ? $locations[0] : '--';
			?>
				<h1 class="line-height-2 center product-title mb3"><?php echo esc_html( get_the_title() ); ?></h1>
				<div class="lg-flex justify-between">
					<div class="product-details lg-col-2">
						<div class="h4 line-height-2">
							<p class="travel-results-result-subtext mb1"><?php echo esc_html( $location ); ?></p>
							<?php /* translators: %d: Number of reviews. */ ?>
							<p class="travel-results-result-subtext"><?php echo sprintf( esc_html__( '%d Reviews', 'travel' ), esc_html( $comments->approved ) ); ?></p>
							<div class="relative h2 line-height-2 mb1">
								<div class="travel-results-result-stars green">
									<?php for ( $i = 0; $i < $rating; $i++ ) : ?>
										★
									<?php endfor; ?>
								</div>
							</div>
							<p class="travel-results-result-subtext"><?php esc_html_e( 'Share', 'travel' ); ?></p>
							<div class="ampstart-social-box mb1">
								<amp-social-share type="facebook"
									aria-label="<?php esc_attr_e( 'Share this on Facebook', 'travel' ); ?>"
									data-param-text="<?php esc_attr_e( 'Hello world', 'travel' ); ?>"
									data-param-href="<?php echo esc_url( 'https://example.com/?ref=URL', 'travel' ); ?>"
									data-param-app_id="145634995501895"></amp-social-share>
								<amp-social-share type="gplus" aria-label="<?php esc_attr_e( 'Share this on Google Plus', 'travel' ); ?>"></amp-social-share>
								<amp-social-share type="twitter" aria-label="<?php esc_attr_e( 'Share this on Twitter', 'travel' ); ?>"></amp-social-share>
							</div>
						</div>
					</div>
					<!-- / product-details -->

					<div class="product-cta lg-col-2 lg-right-align">
						<h4 class="product-cta-title mb2 line-height-1">$100</h4>

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
						if ( comments_open() || 0 < $comments->approved ) :
							comments_template();
						endif;
						?>
					</div>
					<!-- / product-main -->

				</div>
				<!-- / lg-flex -->
		<?php
			endwhile;
		endif;
		?>

	</div>
</div>
<!-- / Product Wrap -->

<div id="travel-landing-content" class="travel-landing-content relative">

	<div class="travel-footer-wrapper">

		<!-- Popular -->
		<?php amp_travel_render_similar_adventures(); ?>
		<!--/ Popular -->

		<!-- Search -->
		<section class='travel-search py4 xs-hide sm-hide relative'>
			<div class='px1 md-px2 pb1 relative'>
				<h3 class='travel-search-heading travel-spacing-none h1 bold mb2 center'><?php esc_html_e( 'Have a specific destination in mind?' ); ?></h3>

				<div class='flex justify-center pb2'>
					<div class='travel-input-group flex items-center col-8'>
						<input class='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left' type='text' name='query' placeholder='<?php esc_html_e( 'Search for adventures' ); ?>' on='input-throttled:AMP.setState({search_query: {search: event.value}})' value='' [value]='search_query.search' />
						<span class='travel-input-group-sep travel-border-gray relative z1 block'></span>
						<a href='<?php echo get_site_url(); ?>?s=' [href]='"<?php echo get_site_url(); ?>?s=" + search_query.search' class='travel-link travel-input travel-input-big line-height-2 link rounded-right nowrap text-decoration-none'>
						<?php esc_html_e( 'Find my next adventure' ); ?>
						</a>
					</div>
				</div>
			</div>
		</section>
		<!--/ Search -->
	</div>
</div>
<?php get_footer(); ?>
