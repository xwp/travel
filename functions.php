<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

// Include required classes.
require_once get_template_directory() . '/includes/class-amp-travel-cpt.php';
require_once get_template_directory() . '/includes/class-amp-travel-blocks.php';

if ( ! function_exists( 'travel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WPAMPTheme, use a find and replace
		 * to change 'travel' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel', get_template_directory() . '/languages' );

		add_theme_support( 'amp', array() );

		// Init custom post type.
		new AMP_Travel_CPT();

		// Init Travel blocks.
		new AMP_Travel_Blocks();
	}
endif;

// Hook into theme after setup.
add_action( 'after_setup_theme', 'travel_setup' );
