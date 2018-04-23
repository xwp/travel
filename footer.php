<?php
/**
 * Theme footer template.
 *
 * @todo Create proper footer template(s).
 * @package WPAMPTheme
 */

?>
<?php if ( ! is_search() ): ?>
			<!-- Footer -->
			<footer class="travel-footer overflow-hidden">

				<div class="relative bg-black">

					<!-- Angle -->
					<div class="travel-footer-angle-block absolute top-0 bottom-0 right-0 xs-hide sm-hide"></div>
					<div class="travel-footer-angle absolute xs-hide sm-hide"></div>
					<!--/ Angle -->

					<!-- Right column -->
					<div class="travel-newsletter-signup">
						<header class="max-width-3 mx-auto px1 md-px2">
							<h4 class="travel-footer-right-column-heading travel-spacing-none h2 mb3 blue"><?php printf( '%s<br/>%s', esc_html( 'Want travel deals' ), esc_html( 'straight to your inbox?' ) ); ?></h4>
							<div class="h4 bold mb1"><?php esc_html_e( 'Sign up to our newsletter', 'travel' ); ?></div>
						</header>
						<div class="relative">
							<div class="travel-footer-input-bg bg-black absolute right-0 left-0 md-hide lg-hide"></div>
							<div class="max-width-3 mx-auto px1 md-px2 relative">
								<div class="travel-input-group flex items-center col-12 rounded travel-shadow">
									<input class="travel-input travel-input-big block col-12 flex-auto rounded-left" type="text" name="email" placeholder="<?php esc_html_e( 'Enter your email', 'travel' ); ?>">
									<span class="travel-input-group-sep travel-border-gray relative z1 block"></span>
									<button type="button" class="travel-link travel-input-big nowrap rounded-right">
										<?php esc_html_e( 'Sign up now', 'travel' ); ?>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!--/ Right column -->

					<!-- Left column -->
					<div class="max-width-3 mx-auto px1 md-px2">
						<div class="flex pt3 md-pt4 col-12 md-col-6 pr3">
							<div class="col-2">
								<a href="<?php echo esc_url( home_url() ); ?>" class="inline-block h2 line-height-1 circle white">
									<svg class="travel-icon travel-icon-logo h2" viewBox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>
								</a>
							</div>
							<?php
							if ( has_nav_menu( 'footer-menu' ) ) {
								wp_nav_menu( array(
									'theme_location'  => 'footer-menu',
									'walker'          => new AMP_Travel_Footer_Menu_Walker(),
									'item_spacing'    => 'discard',
									'container_class' => 'col-10',
								) );
							}
							?>
						</div>
						<div class="py3 gray">
							<?php printf( '&copy; Copyright %d', esc_html( date( 'Y' ) ) ); ?>
						</div>
					</div>
					<!--/ Left column -->
				</div>
			</footer>
<?php endif; ?>
<!--/ Footer  -->
<?php wp_footer(); ?>

		</section>
	</body>
</html>
