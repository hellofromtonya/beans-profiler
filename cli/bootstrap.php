<?php
/**
 * Bootstraps the WordPress Micro-Profiler CLI.
 *
 * @package     Beans\Profiler\CLI
 * @since       1.5.0
 * @link        http://www.getbeans.io
 * @license     GNU-2.0+
 *
 * @group       micro-profiler
 */

/**
 * Profile memory usage for the Beans Actions API Container, comparing
 * storing actions into the container as an array vs. an encoded string.
 *
 * Test parameters are:
 *
 * 1. Cycle 1,000,000 times.
 * 2. Added the action into the "added" container.
 * 3. Test both scenarios.
 * 4. Compare results.
 */

// Define the absolute 'wp-content' path.
define( 'WP_CONTENT_DIR', dirname( dirname( dirname( getcwd() ) ) ) . '/wp-content/' ); // @codingStandardsIgnoreLine.

if ( ! file_exists( WP_CONTENT_DIR ) ) {
	trigger_error( 'Unable to run the micro-profiler, because the wp-content folder does not exist.', E_USER_ERROR );  // @codingStandardsIgnoreLine.
}

if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . 'plugins/' ); // @codingStandardsIgnoreLine.
}

/**
 * Get the WordPress' tests suite directory.
 *
 * @since 1.5.0
 *
 * @return string
 */
function beans_get_wp_tests_dir() {
	$tests_dir = getenv( 'WP_TESTS_DIR' );

	// Travis CI & Vagrant SSH tests directory.
	if ( empty( $tests_dir ) ) {
		$tests_dir = '/tmp/wordpress-tests';
	}

	// If the tests' includes directory does not exist, try a relative path to the Core tests directory.
	if ( ! file_exists( $tests_dir . '/includes/' ) ) {
		$tests_dir = '../../../../tests/phpunit';
	}

	// Check it again. If it doesn't exist, stop here and post a message as to why we stopped.
	if ( ! file_exists( $tests_dir . '/includes/' ) ) {
		trigger_error( 'Unable to run the micro-profiler, because the WordPress test suite could not be located.', E_USER_ERROR );  // @codingStandardsIgnoreLine.
	}

	// Strip off the trailing directory separator, if it exists.
	return rtrim( $tests_dir, DIRECTORY_SEPARATOR );
}

/**
 * Autoload the profiles' files.
 */
function beans_autoload_profiles() {
	$files = array(
		'profiles/api/actions.php',
		'profiles/api/filters.php',
		'profiles/api/image.php',
		'fixtures/functions.php',
	);

	foreach ( $files as $file ) {
		require __DIR__ . DIRECTORY_SEPARATOR . $file;
	}
}

// Find the WP tests suite directory.
$beans_tests_dir = beans_get_wp_tests_dir();

// Load up the profiler files.
beans_autoload_profiles();

// Give access to tests_add_filter() function.
require_once $beans_tests_dir . '/includes/functions.php';

/**
 * Register with "setup_theme" in the WP tests suite to set the themes directory
 * and load the Beans framework.
 */
tests_add_filter( 'setup_theme', function() {
	global $argv;

	$theme_name = 'baseline-micro-profiler' === $argv[2] ? 'beans-v1.4.0' : 'tm-beans';
	define( 'BEANS_PROFILER_THEME', $theme_name );

	register_theme_directory( WP_CONTENT_DIR . 'themes' );
	switch_theme( $theme_name );
} );

// Start up the WP testing environment.
require_once $beans_tests_dir . '/includes/bootstrap.php';
