<?php
/**
 * AMP Travel Theme.
 *
 * @package WPAMPTheme
 */

// Load theme.
require_once get_template_directory() . '/includes/functions.php';
require_once get_template_directory() . '/includes/class-amp-travel-theme.php';
require_once get_template_directory() . '/includes/class-amp-travel-cpt.php';

// Initialize theme.
amp_travel_theme()->init();
