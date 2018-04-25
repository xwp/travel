<?php
/**
 * AMP Travel Theme.
 *
 * @package WPAMPTheme
 */

define( 'AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL', 15000 );

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

if ( ! function_exists( 'travel_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on travel, use a find and replace
		 * to change 'travel' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'travel' ),
			)
		);

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'travel_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo', array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support(
			'gutenberg', array(
				'wide-images' => true,
				'colors'      => array(
					'#0073aa',
					'#229fd8',
					'#eee',
					'#444',
				),
			)
		);

	}
endif;
add_action( 'after_setup_theme', 'travel_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function travel_content_width() {

	if ( isset( $GLOBALS['content_width'] ) ) {
		$content_width = $GLOBALS['content_width'];
	}

	// Check if the sidebar is in use.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 864;
	} else {
		$content_width = 864;
	}

	/**
	 * Filter content width of the theme.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'travel_content_width', $content_width );
}
add_action( 'template_redirect', 'travel_content_width', 0 );

/**
 * Register Google Fonts
 */
function travel_fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Roboto Sans does not support characters in your language, translate this to 'off'.
	 */
	$lora = esc_html_x( 'on', 'Roboto Sans font: on or off', 'travel' );
	/**
	 * Translator: If Crimson Text does not support characters in your language, translate this to 'off'.
	 */
	$raleway = esc_html_x( 'on', 'Crimson Text font: on or off', 'travel' );

	$font_families = array();

	if ( 'off' !== $lora ) {
		$font_families[] = 'Roboto Condensed:300,300i,400,400i';
	}

	if ( 'off' !== $raleway ) {
		$font_families[] = 'Crimson Text:400,400i,600,600i';
	}

	if ( in_array( 'on', array( $lora, $raleway ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );

}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function travel_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'travel-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'travel_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function travel_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'travel' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'travel' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'travel_widgets_init' );

/**
 * Enqueue styles.
 */
function travel_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'travel-fonts', travel_fonts_url(), array(), null );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'travelbase-style', get_stylesheet_uri(), array(), '20151215' );

	// Register component styles that are printed as needed.
	wp_register_style( 'travel-comments', get_theme_file_uri() . '/css/comments.css', array(), '20151215' );
	wp_register_style( 'travel-content', get_theme_file_uri() . '/css/content.css', array(), '20151215' );
	wp_register_style( 'travel-sidebar', get_theme_file_uri() . '/css/sidebar.css', array(), '20151215' );
	wp_register_style( 'travel-widgets', get_theme_file_uri() . '/css/widgets.css', array(), '20151215' );
	wp_register_style( 'travel-front-page', get_theme_file_uri() . '/css/front-page.css', array(), '20151215' );
}
add_action( 'wp_enqueue_scripts', 'travel_styles' );

/**
 * Enqueue scripts.
 */
function travel_scripts() {

	if ( ! travel_is_amp() ) {
		wp_enqueue_script( 'travel-navigation', get_theme_file_uri() . '/js/navigation.js', array(), '20151215', false );
		wp_script_add_data( 'travel-navigation', 'async', true );

		wp_enqueue_script( 'travel-skip-link-focus-fix', get_theme_file_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', false );
		wp_script_add_data( 'travel-skip-link-focus-fix', 'defer', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'travel_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/pluggable/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Bring in theme features bootstrap
 */
require_once get_template_directory() . '/inc/features-bootstrap.php';