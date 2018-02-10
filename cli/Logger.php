<?php
/**
 * Description
 *
 * @package     Beans\Profiler\CLI
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */

namespace Beans\Profiler\CLI;

class Logger {

	/**
	 * Array of micro profiles.
	 *
	 * @var array
	 */
	protected $profiles = array();

	/**
	 * Absolute path to the baseline results file.
	 *
	 * @var string
	 */
	protected $baseline_file;

	/**
	 * Sample size for the profiler.
	 *
	 * @var int
	 */
	protected $sample_size;

	/**
	 * Logger constructor.
	 *
	 * @param int $sample_size Sample size for the profiler.
	 */
	public function __construct( $sample_size ) {
		$this->sample_size   = $sample_size;
		$this->baseline_file = __DIR__ . '/config/baseline.php';
	}

	/**
	 * Print the summary.
	 *
	 * @since 1.0.0
	 *
	 * @param array $profiles Array of profiles.
	 *
	 * @return void
	 */
	public function print_summary( array $profiles ) {
		$this->profiles = $profiles;

		if ( 'tm-beans' === BEANS_PROFILER_THEME ) {
			require __DIR__ . '/views/full-summary.php';
		} else {
			require __DIR__ . '/views/baseline-summary.php';
			$this->store_baseline_results();
		}

		$this->profiles = null;
	}

	/**
	 * Get the baseline results.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_baseline_results() {
		return (array) json_decode( file_get_contents( $this->baseline_file ) ); // @codingStandardsIgnoreLine.
	}

	/**
	 * Store the baseline results.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function store_baseline_results() {
		$results = array();

		foreach ( $this->profiles as $name => $profile ) {
			$results[ $name ] = $profile->get( 'avg_time' );
		}

		// Store the results in a file.
		file_put_contents( $this->baseline_file, json_encode( $results ) ); // @codingStandardsIgnoreLine.
	}

	/**
	 * Print the full segment.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $name    Name of the profile.
	 * @param Profile $profile The given profile to print out.
	 *
	 * @return void
	 */
	protected function print_segment( $name, Profile $profile ) {
		$color = $this->get_color( $profile->get( 'time_difference' ) );

		if ( $color ) {
			printf( "|\033[%sm %-30s \033[0m  ", $color, $name ); // @codingStandardsIgnoreLine.

			// Need to compensate for the negative sign.
			if ( $profile->get( 'time_difference' ) < 0.0 ) {
				printf( "|   \033[%sm %0.6f \033[0m ", $color, $profile->get( 'time_difference' ) ); // @codingStandardsIgnoreLine.
			} else {
				printf( "|    \033[%sm %0.6f \033[0m ", $color, $profile->get( 'time_difference' ) ); // @codingStandardsIgnoreLine.
			}
		} else {
			printf( "| %-30s ", $name ); // @codingStandardsIgnoreLine.

			// Need to compensate for the negative sign.
			if ( $segment['time_difference'] < 0.0 ) {
				printf( "|   %0.6f ", $profile->get( 'time_difference' ) ); // @codingStandardsIgnoreLine.
			} else {
				printf( "|    %0.6f ", $profile->get( 'time_difference' ) ); // @codingStandardsIgnoreLine.
			}
		}

		printf( "|      %0.6f |      %0.6f \n", $profile->get( 'avg_time' ), $profile->get( 'baseline' ) ); // @codingStandardsIgnoreLine.
	}

	/**
	 * Get the color.
	 *
	 * @since 1.0.0
	 *
	 * @param float $difference The difference from the baseline time.
	 *
	 * @return string
	 */
	protected function get_color( $difference ) {

		// If we increased by at least 0.1 ms, return a "red" background.
		if ( $difference >= 0.1 ) {
			return '41';
		}

		// If we increased by at least 0.01 ms, return a "red" color.
		if ( $difference > 0.01 ) {
			return '31';
		}

		// If we increased by at least 0.001 ms, return a "yellow" color.
		if ( $difference > 0.001 ) {
			return '1;33';
		}

		// If we decreased by at least 0.01ms, return a "green" background.
		if ( $difference < 0.01 ) {
			return '32';
		}

		// If we decreased, return a "green" color.
		if ( $difference < 0.0 ) {
			return '32';
		}
	}
}
