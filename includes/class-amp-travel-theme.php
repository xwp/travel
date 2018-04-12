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
	 * AMP_Travel_Theme constructor.
	 */
	protected function __construct() {
		$this->includes();
		$this->instantiate_classes();
	}

	/**
	 * Init classes.
	 */
	protected function instantiate_classes() {

		// Init blocks.
		$travel_blocks = new AMP_Travel_Blocks();
		$travel_blocks->init();

		// Init taxonomies.
		$travel_taxonomies = new AMP_Travel_Taxonomies();
		$travel_taxonomies->init();

		// Init CPT.
		$travel_cpt = new AMP_Travel_CPT();
	}

	/**
	 * Init.
	 */
	public function init() {

		// Hook into theme after setup.
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
	}

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
	}

	/**
	 * Theme includes.
	 */
	protected function includes() {
		$dir = get_template_directory();

		require_once $dir . '/includes/class-amp-travel-taxonomies.php';
		require_once $dir . '/includes/class-amp-travel-blocks.php';
		require_once $dir . '/includes/class-amp-travel-cpt.php';
	}
}
