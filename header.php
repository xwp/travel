<?php
/**
 * Theme header template.
 *
 * @todo Create proper header template(s).
 * @package WPAMPTheme
 */

?>
<!doctype html>
<html amp <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
</head>
<body <?php body_class(); ?>>

<amp-state id="search_query">
	<script type="application/json">
		{
			"search": ""
		}
	</script>
</amp-state>

<?php
echo '<amp-state id="adventure_price"><script type="application/json">"' . esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ) . '"</script></amp-state>
    <amp-state id="adventure_current_price"><script type="application/json">"' . esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ) . '"</script></amp-state>';
?>

<amp-state id="fields_query"><script type="application/json">""</script></amp-state>
<amp-state id="query_query"><script type="application/json">""</script></amp-state>

<section class="travel-main-wrapper overflow-hidden" role="main">

	<!-- Results Navbar -->
	<header class="travel-results-navbar pt4 pr4 pl4">
		<div class="px1 md-px2 flex justify-between items-stretch">
			<div class="flex items-stretch">
				<a href="travel.amp" class="travel-results-navbar-icon h2 circle my1 md-my2">
					<svg class="travel-icon travel-icon-logo h2" viewBox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>      </a>
			</div>
		</div>
	</header>
	<!--/ Results Navbar -->
