<?php
/**
 * Display archive page navbar.
 *
 * @package WPAMPTheme
 */

?>
<!-- Results Navbar -->
<header class="travel-results-navbar pt4 pr4 pl4">
	<div class="px1 md-px2 flex justify-between items-stretch">
		<div class="flex items-stretch">
			<a href="<?php echo esc_url( home_url() ); ?>" class="travel-results-navbar-icon h2 circle my1 md-my2">
				<svg class="travel-icon travel-icon-logo h2" viewBox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>
			</a>
			<div class="archive-title flex flex-auto items-center">
				<div>
					<div class="h3 line-height-2 bold">
						<?php echo esc_html( get_the_archive_title() ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--/ Results Navbar -->
