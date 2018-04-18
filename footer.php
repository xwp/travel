<?php
/**
 * Theme footer template.
 *
 * @todo Create proper footer template(s).
 * @package WPAMPTheme
 */

// Ignore the issues of this file since that's just a copied HTML placeholder.
// @codingStandardsIgnoreFile
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
				<h4 class="travel-footer-right-column-heading travel-spacing-none h2 mb3 blue">Want travel deals<br>straight to your inbox?</h4>
				<div class="h4 bold mb1">Sign up to our newsletter</div>
			</header>
			<div class="relative">
				<div class="travel-footer-input-bg bg-black absolute right-0 left-0 md-hide lg-hide"></div>
				<div class="max-width-3 mx-auto px1 md-px2 relative">
					<div class="travel-input-group flex items-center col-12 rounded travel-shadow">
						<input class="travel-input travel-input-big block col-12 flex-auto rounded-left" type="text" name="email" placeholder="Enter your email">
						<span class="travel-input-group-sep travel-border-gray relative z1 block"></span>
						<button type="button" class="travel-link travel-input-big nowrap rounded-right">
							Sign up now
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
					<a href="travel.amp" class="inline-block h2 line-height-1 circle white">
						<svg class="travel-icon travel-icon-logo h2" viewBox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>          </a>
				</div>
				<div class="col-5">
					<h4 class="travel-spacing-none mb2 h3 gray bold">Company</h4>
					<div class="line-height-4 mb4">
						<a href="#" class="travel-link block gray">About</a>
						<a href="#" class="travel-link block gray">Careers</a>
						<a href="#" class="travel-link block gray">Contact</a>
					</div>
				</div>
				<div class="col-5">
					<h4 class="travel-spacing-none mb2 h3 gray bold">Discover</h4>
					<div class="line-height-4 mb4">
						<a href="#" class="travel-link block gray">Activities</a>
						<a href="#" class="travel-link block gray">Tours</a>
						<a href="#" class="travel-link block gray">Experiences</a>
						<a href="#" class="travel-link block gray">Featured Adventures</a>
						<a href="#" class="travel-link block gray">Search</a>
					</div>
				</div>
			</div>
			<div class="py3 gray">
				&copy; Copyright 2018
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