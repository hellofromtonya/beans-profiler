<?php
/**
 * Description
 *
 * @package     Beans\Framework\Tests\Profiler
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */

namespace Beans\Profiler\CLI;

use WP_UnitTestCase;

class Micro_Profiler extends WP_UnitTestCase {

	/**
	 * Array of micro profiles.
	 *
	 * @var array
	 */
	protected $profiles = array();

	/**
	 * Function names to profile.
	 *
	 * @var array
	 */
	protected static $functions_to_profile;

	/**
	 * Absolute path to the baseline results file.
	 *
	 * @var string
	 */
	protected static $baseline_file;

	/**
	 * Sample size for the profiler.
	 *
	 * @var int
	 */
	const SAMPLE_SIZE = 10000;

	/**
	 * Set up the test before we run the test setups.
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();

		static::$functions_to_profile = require __DIR__ . '/config/micro-profiler.php';
		static::$baseline_file        = __DIR__ . '/config/baseline.php';
	}

	/**
	 * Set up the test.
	 */
	public function setUp() {
		parent::setUp();

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
			foreach ( static::$functions_to_profile as $function ) {
				$function( $this );
			}

			$index ++;
		} while ( $index < self::SAMPLE_SIZE );

		$this->print_summary();

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
		$this->profiles[ $name ]['start_time'] = microtime( true ) * 1000;
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
		$this->profiles[ $name ]['execution_time'] += microtime( true ) * 1000 - $this->profiles[ $name ]['start_time'];
		$this->profiles[ $name ]['start_time']     = 0.0;
	}

	/**
	 * Print the summary.
	 */
	protected function print_summary() {

		if ( 'tm-beans' !== BEANS_PROFILER_THEME ) {
			$results = $this->print_baseline_summary();
			$this->store_baseline_results( $results );
		} else {
			$baseline = (array) json_decode( file_get_contents( static::$baseline_file ) ); // @codingStandardsIgnoreLine.
			$this->print_full_summary( $baseline );
		}

		$this->profiles = array();
	}

	/**
	 * Print the summary.
	 *
	 * @since 1.0.0
	 *
	 * @param array $baseline Array of baseline times.
	 */
	protected function print_full_summary( array $baseline ) {
		echo "\n\n=================\n";
		printf( "The following functions were invoked %s times during this micro profiler process.\n\n", number_format( self::SAMPLE_SIZE ) ); // @codingStandardsIgnoreLine.
		echo "\t 1. The 'time' column shows the function's average execution time in milliseconds (ms).\n";
		echo "\t 2. 'v1.4.0' shows the same micro-profiler run on Beans v1.4.0.\n";
		echo "\t 3. The 'diff' column = 'time' - 'v1.4.0', in milliseconds.";
		echo "\n\n\n";

		echo "| ------------------------------ | ------------- | ------------- | ------------- \n";
		echo "| name                           | time (ms)     |  v1.4.0 (ms)   | diff (ms) \n";
		echo "| ------------------------------ | ------------- | ------------- | ------------- \n";

		foreach ( $this->profiles as $name => $segments ) {
			$time = $segments['execution_time'] / self::SAMPLE_SIZE;
			printf( "| %-30s |      %0.6f |      %0.6f |      %0.6f \n", $name, $time, $baseline[ $name ], $time - $baseline[ $name ] ); // @codingStandardsIgnoreLine.
		}

		echo "| ------------------------------ | ------------- | ------------- | ------------- \n";
		$this->profiles = array();
	}

	/**
	 * Print the summary.
	 */
	protected function print_baseline_summary() {
		echo "\n\n=================\n";
		printf( "The following functions were invoked %s times during this micro profiler process.\n\n", number_format( self::SAMPLE_SIZE ) ); // @codingStandardsIgnoreLine.
		echo "\n\n\n";

		echo "| ------------------------------ | ------------- \n";
		echo "| name                           | time (ms)     \n";
		echo "| ------------------------------ | ------------- \n";

		$results = array();

		foreach ( $this->profiles as $name => $segments ) {
			$results[ $name ] = $segments['execution_time'] / self::SAMPLE_SIZE;
			printf( "| %-30s |      %0.6f \n", $name, $results[ $name ] ); // @codingStandardsIgnoreLine.git i
		}

		echo "| ------------------------------ | ------------- | \n";

		return $results;
	}

	/**
	 * Store the baseline results.
	 *
	 * @since 1.0.0
	 *
	 * @param array $results Array of results.
	 *
	 * @return void
	 */
	protected function store_baseline_results( array $results ) {
		file_put_contents( static::$baseline_file, json_encode( $results ) ); // @codingStandardsIgnoreLine.
	}

	/**
	 * Initialize the profiles for the functions to be profiled.
	 */
	protected function init_profiles() {
		$this->profiles = array();
		$default        = array(
			'start_time'         => 0.0,
			'execution_time'     => 0,
			'start_memory_usage' => 0.0,
			'memory_usage'       => 0,
		);

		foreach ( array_keys( static::$functions_to_profile ) as $function_name ) {
			$this->profiles[ $function_name ] = $default;
		}
	}
}
