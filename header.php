<?php
/**
 * Theme header template.
 *
 * @todo Create proper header template(s).
 * @package WPAMPTheme
 */

// Ignore the issues of this file since that's just a copied HTML placeholder.
// @codingStandardsIgnoreFile

?>

<!doctype html>
<html ⚡="">

<head>
	<meta charset="utf-8">
	<title>Travel Template</title>
	<link rel="canonical" href="https://www.ampstart.com/templates/travel/travel-results.amp">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

	<script async="" src="https://cdn.ampproject.org/v0.js"></script>

	<style amp-boilerplate="">body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate="">body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>

	<script custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js" async=""></script>
	<script custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js" async=""></script>
	<script custom-element="amp-list" src="https://cdn.ampproject.org/v0/amp-list-0.1.js" async=""></script>

	<script custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.1.js" async=""></script>

	<script custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js" async=""></script>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">

	<link rel="stylesheet" href="/wordpress/wp-content/themes/ampstart/css/templates/travel/page.css">
</head>
<body>

<amp-state id="search_query">
    <script type="application/json">
        {
	        "search": ""
        }
    </script>
</amp-state>

<amp-state id="fields_query"><script type="application/json">""</script></amp-state>
<amp-state id="query_query"><script type="application/json">""</script></amp-state>

<section class="travel-main-wrapper overflow-hidden" role="main">

	<!-- Results Navbar -->
	<header class="travel-results-navbar pt4 pr4 pl4">
		<div class="px1 md-px2 flex justify-between items-stretch">
			<div class="flex items-stretch">
				<a href="travel.amp" class="travel-results-navbar-icon h2 circle my1 md-my2">
					<svg class="travel-icon travel-icon-logo h2" viewBox="0 0 100 100"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="7.5"><circle cx="50" cy="50" r="45"></circle><path d="M20.395 83.158c-2.37-10.263-.79-18.553 4.737-24.87 8.29-9.472 17.763-1.183 26.052-9.472 8.29-8.29 2.37-18.948 10.658-26.053 5.526-4.737 12.237-6.316 20.132-4.737M39.084 95c-2.788-10.2-1.912-17.304 2.627-21.316 6.808-6.017 14.956-.68 24.088-9.623 9.13-8.94 3.062-17.133 10.255-23.534 4.795-4.267 10.282-5.668 16.46-4.203"></path></g></svg>      </a>
				<div class="ml3 flex items-center xs-hide sm-hide">
					<amp-list class="travel-block-list flex items-center" layout="flex-item" noloading="" src="/api/search?maxPrice=800&query=&sort=popularity-desc" [src]="
  '/api/search?maxPrice=' + (query_maxPrice < 801 ? query_maxPrice : 0) +
  '&query=' + query_query +
  (query_city.length ? '&cities[]=' + query_city.join('&cities[]=') : '') +
  (query_type.length ? '&types[]=' + query_type.join('&types[]=') : '') +
  '&sort=' + query_sort
">
						<template type="amp-mustache">
							<div class="flex items-center">
								<label class="travel-input-icon relative">
									<input class="travel-input travel-input-dark rounded" type="text" name="query" placeholder="Location" on="
                      change:
                        AMP.setState({fields_query: event.value}),
                        AMP.setState({query_query: event.value})
                    " value="{{stats.location}}">
									<span class="travel-icon travel-img-icon-map-pin-transparent"></span>
								</label>
							</div>
						</template>
					</amp-list>
				</div>
			</div>
		</div>
	</header>
	<!--/ Results Navbar -->