<?php
/**
 * This is a static placeholder for the actual index.php
 * file for the purpose of displaying Gutenberg blocks in front-end.
 * It's a direct copy of the source of the Travel theme homepage template,
 * copying the header, style, and footer. Elements covered by blocks are not copied.
 * @todo Create proper templates.
 */

// Ignore the issues of this file since that's just a copied HTML placeholder and contains some issues (e.g. including the scripts directly.)

// @codingStandardsIgnoreFile
get_header();
?>
	<section class="relative z2">
		<header class="travel-header absolute top-0 right-0 left-0">
			<div class="px1 md-px2 py1 md-py2 flex justify-between items-center">
				<a href="travel.amp" class="travel-icon-logo mx-auto inline-block circle">
					<svg class="travel-icon travel-icon-logo h2" viewbox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>        </a>
			</div>
		</header>
	</section>

	<!-- Hero -->
	<div class="travel-hero-bg absolute col-12">
		<amp-img class="travel-hero-bg-img absolute" src="<?php echo esc_html( get_template_directory_uri() ); ?>/img/hero-2.jpg" height="80vmax" noloading="" width="100vw"></amp-img>
		<amp-img class="travel-hero-bg-img absolute" src="<?php echo esc_html( get_template_directory_uri() ); ?>/img/hero-3.jpg" height="80vmax" noloading="" width="100vw"></amp-img>
		<amp-img class="travel-hero-bg-img absolute" src="<?php echo esc_html( get_template_directory_uri() ); ?>/img/hero-1.jpg" height="80vmax" noloading="" width="100vw"></amp-img>
	</div>
<?php
if ( have_posts() ) :

	/* Start the Loop */
	while ( have_posts() ) :
		the_post();
		the_content();

	endwhile;

endif;

get_footer();
?>
