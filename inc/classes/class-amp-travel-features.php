<?php
/**
 * AMP Travel Theme Features class.
 *
 * @package WPAMPTheme
 */

/**
 * Class AMP_Travel_Features.
 *
 * @package WPAMPTheme
 */
class AMP_Travel_Features {

	/**
	 * Array of feature objects.
	 *
	 * @var stdClass
	 */
	public $features;

	/**
	 * Get theme instance.
	 *
	 * @return object $instance Theme instance.
	 */
	public static function get_instance() {
		static $instance;

		if ( ! $instance instanceof AMP_Travel_Features ) {
			$instance = new AMP_Travel_Features();
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
	 * Include feature classes.
	 */
	public function includes() {
		$dir = get_template_directory();

		require_once $dir . '/inc/classes/class-amp-travel-taxonomies.php';
		require_once $dir . '/inc/classes/class-amp-travel-blocks.php';
		require_once $dir . '/inc/classes/class-amp-travel-cpt.php';
		require_once $dir . '/inc/classes/class-amp-travel-taxonomies.php';
	}

	/**
	 * Init classes.
	 */
	public function instantiate_classes() {
		$this->features = new stdClass();

		// Init blocks.
		$this->features->blocks = new AMP_Travel_Blocks();
		$this->features->blocks->init();

		// Init custom post type.
		$this->features->cpt = new AMP_Travel_CPT();
		$this->features->cpt->init();

		// Init taxonomies.
		$this->features->taxonomies = new AMP_Travel_Taxonomies();
		$this->features->taxonomies->init();
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

}
