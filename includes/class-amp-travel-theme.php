<?php
/**
 * AMP Travel Theme class.
 *
 * @package WPAMPTheme
 */

/**
 * Class AMP_Travel_Theme.
 *
 * @package WPAMPTheme
 */
class AMP_Travel_Theme {

	/**
	 * Get theme instance.
	 *
	 * @return object $instance Theme instance.
	 */
	public static function get_instance() {
		static $instance;

		if ( ! $instance instanceof AMP_Travel_Theme ) {
			$instance = new AMP_Travel_Theme();
		}

		return $instance;
	}

	/**
	 * Init.
	 */
	public function init() {
		$this->includes();
		$this->instantiate_classes();
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
	}

	/**
	 * Theme includes.
	 */
	public function includes() {
		$dir = get_template_directory();
		require_once $dir . '/includes/class-amp-travel-blocks.php';
		require_once $dir . '/includes/class-amp-travel-cpt.php';
		require_once $dir . '/includes/class-amp-travel-taxonomies.php';
		require_once $dir . '/includes/class-amp-travel-footer-menu-walker.php';
	}

	/**
	 * Init classes.
	 */
	public function instantiate_classes() {
		$travel_blocks = new AMP_Travel_Blocks();
		$travel_blocks->init();
		$travel_cpt = new AMP_Travel_CPT();
		$travel_cpt->init();
		$travel_taxonomies = new AMP_Travel_Taxonomies();
		$travel_taxonomies->init();
	}

	/**
	 * Setup.
	 */
	public function setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WPAMPTheme, use a find and replace
		 * to change 'travel' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel', get_template_directory() . '/languages' );

		add_theme_support( 'amp', array() );
		add_image_size( 'travel-600x300', 600, 300, true );
		add_image_size( 'travel-1000x560', 1000, 560, true );
	}

}
