<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

/**
 * Init theme.
 *
 * @return object Theme object
 */
function amp_travel_theme() {
	return AMP_Travel_Theme::get_instance();
}

/**
 * Add AMP states.
 */
function amp_travel_states() {
	?>
	<?php if ( is_singular( 'adventure' ) ) : ?>
		<amp-state id="adventure_price"><script type="application/json"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></script></amp-state>
		<amp-state id="adventure_current_price"><script type="application/json"><?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></script></amp-state>
	<?php else : ?>
		<amp-state id="search_query">
			<script type="application/json">
				{
					"search": ""
				}
			</script>
		</amp-state>

		<amp-state id="fields_query"><script type="application/json">""</script></amp-state>
		<amp-state id="fields_query_initial"><script type="application/json">""</script></amp-state>
		<amp-state id="fields_query_live"><script type="application/json">""</script></amp-state>
		<amp-state id="fields_query_edited"><script type="application/json">false</script></amp-state>
		<amp-state id="query_query"><script type="application/json">""</script></amp-state>

		<amp-state id="fields_start"><script type="application/json">""</script></amp-state>
		<amp-state id="fields_end"><script type="application/json">""</script></amp-state>
	<?php
	endif;
}
add_action( 'wp_footer', 'amp_travel_states' );

/**
 * Enqueues styles.
 */
function amp_travel_enqueue_styles() {
	if ( is_search() ) {
		wp_enqueue_style( 'amp_travel_search', get_template_directory_uri() . '/assets/css/search.css' );
	} else {
		wp_enqueue_style( 'amp_travel_homepage', get_template_directory_uri() . '/assets/css/homepage.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'amp_travel_enqueue_styles' );
