<?php
/**
 * Display breadcrumbs.
 *
 * @package WPAMPTheme
 */

if ( ! is_tax() ) {
	return;
}
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
?>
<div id="crumb" class="py2 pl2 pr2 border-bottom travel-border-gray">
	<span class="bold py1 pl1 pr1"><a class="travel-link" href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Home' ); ?></a></span>
	<span class="travel-results-result-subtext">></span>
	<span class="bold py1 pl1 pr1"><?php echo ucfirst( esc_html( $term->taxonomy ) ); ?></span>
	<span class="travel-results-result-subtext">></span>
	<span class="travel-results-result-subtext py1 pl1 pr1"><?php echo wp_kses_post( amp_travel_get_archive_title() ); ?></span>
</div>
