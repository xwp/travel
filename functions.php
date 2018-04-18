<?php
/**
 * AMP Travel Theme.
 *
 * @package WPAMPTheme
 */

if ( ! file_exists( get_template_directory() . '/assets/js/editor-blocks.js' ) ) {
	/**
	 * Print admin notice when theme build is needed.
	 */
	function _amp_travel_print_build_needed_admin_notice() {
		?>
		<div class="notice notice-error">
			<p><?php esc_html_e( 'You appear to be running the current theme from source. Please do `npm run build` to finish installation.', 'travel' ); ?></p>
		</div>
		<?php
	}
	add_action( 'admin_notices', '_amp_travel_print_build_needed_admin_notice' );
}

// Load theme.
require_once get_template_directory() . '/includes/functions.php';
require_once get_template_directory() . '/includes/class-amp-travel-theme.php';

// Initialize theme.
amp_travel_theme()->init();
