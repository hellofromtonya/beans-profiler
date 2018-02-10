<?php
/**
 * Micro Profiler
 *
 * This micro profiler runs off of PHPUnit and WP_UnitTestCase.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.0.0
 */

namespace Beans\Profiler\CLI;

use WP_UnitTestCase;

/**
 * Class MicroProfiler
 *
 * @package Beans\Profiler\CLI
 */
class MicroProfiler extends WP_UnitTestCase {

	/**
	 * Sample size for the profiler.
	 *
	 * @var array
	 */
	protected $config;


	/**
	 * Array of micro profiles.
	 *
	 * @var array
	 */
	protected $profiles = array();

	/**
	 * Instance of the logger.
	 *
	 * @var Logger
	 */
	protected $logger;

	/**
	 * Set up the test.
	 */
	public function setUp() {
		parent::setUp();

		$this->config = require __DIR__ . '/config/micro-profiler.php';
		$this->logger = new Logger( $this->config['sample_size'] );

		$this->set_permalink_structure( '/%year%/%monthnum%/%day%/%postname%/' );
		$this->init_profiles();
	}

	/**
	 * Run the profiler.
	 */
	public function test_run_micro_profiler() {
		$index = 0;

		do {

			// Invoke each of the registered functions to profile.
			foreach ( $this->config['functions_to_profile'] as $function ) {
				$function( $this );
			}

			$index ++;
		} while ( $index < $this->config['sample_size'] );

		$this->run_stats();
		$this->logger->print_summary( $this->profiles );

		$this->assertTrue( true );
	}

	/**
	 * Starts the micro-profiler for this segment.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name for this segment.
	 *
	 * @return void
	 */
	public function start_segment( $name ) {
		$this->profiles[ $name ]->start_segment();
	}

	/**
	 * Starts the micro-profiler for this segment.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name for this segment.
	 *
	 * @return void
	 */
	public function stop_segment( $name ) {
		$this->profiles[ $name ]->stop_segment();
	}

	/**
	 * Initialize the profiles for the functions to be profiled.
	 */
	protected function init_profiles() {
		$this->profiles = array();

		foreach ( array_keys( $this->config['functions_to_profile'] ) as $function_name ) {
			$this->profiles[ $function_name ] = new Profile();
		}
	}

	/**
	 * Run the statistics on the profiles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function run_stats() {
		$baseline_results = $this->logger->get_baseline_results();

		foreach ( $this->profiles as $name => $profile ) {
			$profile->run_stats( $baseline_results[ $name ] );
		}
	}
}
