<?php
/**
 * Theme features bootstrap file.
 *
 * @package WPAMPTheme
 */

/**
 * AMP_Travel_Features object helper function.
 *
 * @return object Theme object
 */
function amp_travel_features() {
	return AMP_Travel_Features::get_instance();
}

// Require the features class.
require_once get_template_directory() . '/inc/classes/class-amp-travel-features.php';

// Initialize features.
amp_travel_features()->init();
