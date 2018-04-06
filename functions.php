<?php
/**
 * Theme functions file.
 *
 * @package WPAMPTheme
 */

// Include required classes.
require_once get_template_directory() . '/includes/class-amp-travel-cpt.php';


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

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Image Sizes.
		$image_sizes = apply_filters( 'amp_travel_image_sizes', array(
			'1600x900',
			'1400x787',
			'1200x675',
			'1040x585',
			'768x432',
			'727x409',
			'600x338',
			'500x281',
			'375x211',
			'335x188',
			'320x180',
			'280x158',
			'240x135',
			'160x90',
			'122x67',
		) );

		// Custom image sizes.
		foreach ( $image_sizes as $size ) {
			$dimensions = explode( 'x', $size );
			add_image_size( 'travel-' . $size, $dimensions[0], $dimensions[1], true );
		}

		// init custom post type.
		new AMP_Travel_CTP();
	}
endif;

// Hook into theme after setup.
add_action( 'after_setup_theme', 'travel_setup' );
