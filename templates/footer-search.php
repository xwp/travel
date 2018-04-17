<?php
/**
 * Template for footer search.
 *
 * @package WPAMPTheme
 */

?>
<!-- Search -->
<section class='travel-search py4 xs-hide sm-hide relative'>
	<div class='px1 md-px2 pb1 relative'>
		<h3 class='travel-search-heading travel-spacing-none h1 bold mb2 center'><?php esc_html_e( 'Have a specific destination in mind?' ); ?></h3>
		<div class='flex justify-center pb2'>
			<div class='travel-input-group flex items-center col-8'>
				<input class='travel-input travel-input-big line-height-2 block col-12 flex-auto rounded-left' type='text' name='query' placeholder='<?php esc_html_e( 'Search for adventures' ); ?>' on='input-throttled:AMP.setState({search_query: {search: event.value}})' value='' [value]='search_query.search' />
				<span class='travel-input-group-sep travel-border-gray relative z1 block'></span>
				<a href='<?php echo esc_url( get_site_url() ); ?>?s=' [href]='"<?php echo esc_url( get_site_url() ); ?>?s=" + search_query.search' class='travel-link travel-input travel-input-big line-height-2 link rounded-right nowrap text-decoration-none'>
					<?php esc_html_e( 'Find my next adventure' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>
<!--/ Search -->
