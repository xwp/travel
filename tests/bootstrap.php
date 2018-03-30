<?php
/**
 * Bootstraps the Unit Tests.
 *
 * @package Travel\Theme\Tests\Integration
 * @since 0.1
 */

if ( ! file_exists( '../../../wp-content' ) ) {
	trigger_error( 'PHPUnit can only run in a WP environment', E_USER_ERROR ); // @codingStandardsIgnoreLine.
}

define( 'TRAVEL_THEME_DIR', dirname( dirname( __FILE__ ) ) );
define( 'WP_CONTENT_DIR', dirname( dirname( getcwd() ) ) ); // @codingStandardsIgnoreLine.

if ( defined( 'WP_CONTENT_DIR' ) && ! defined( 'WP_PLUGIN_DIR' ) ) {
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/' ); // @codingStandardsIgnoreLine.
}

$_tests_dir = getenv( 'WP_TESTS_DIR' );

// Travis CI & Vagrant SSH tests directory.
if ( empty( $_tests_dir ) ) {
	$_tests_dir = '/tmp/wordpress-tests';
}

// Relative path to Core tests directory.
if ( ! file_exists( $_tests_dir . '/includes/' ) ) {
	$_tests_dir = '../../../../tests/phpunit';
}

if ( ! file_exists( $_tests_dir . '/includes/' ) ) {
	trigger_error( 'Unable to locate wordpress-tests-lib', E_USER_ERROR ); // @codingStandardsIgnoreLine.
}

// Give access to tests_add_filter() function.
require_once getenv( 'WP_TESTS_DIR' ) . '/includes/functions.php';

/**
 * Loads theme.
 */
function travel_bootstrap_phpunit_switch_theme() {
	register_theme_directory( WP_CONTENT_DIR . '/themes' );
	switch_theme( basename( TRAVEL_THEME_DIR ) );
}
tests_add_filter( 'setup_theme', 'travel_bootstrap_phpunit_switch_theme' );

// Start up the WP testing environment.
require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';
