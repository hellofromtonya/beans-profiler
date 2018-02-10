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

class Profile {

	/**
	 * The segment's start time (in milliseconds).
	 *
	 * @var float
	 */
	private $start_time = 0.0;

	/**
	 * The total, accumulative execution times.
	 *
	 * @var float
	 */
	private $total_times = 0.0;

	/**
	 * Average number of milliseconds.
	 *
	 * @var float
	 */
	protected $avg_time = 0.0;

	/**
	 * The number of times collected in this profile.
	 *
	 * @var int
	 */
	protected $sample_size = 0;

	/**
	 * The baseline's average milliseconds, used for comparison to determine if the change
	 * as impacted the function's execution time.
	 *
	 * @var float
	 */
	protected $baseline = 0.0;

	/**
	 * Difference to the baseline's averge milliseconds.
	 *
	 * @var float
	 */
	protected $time_difference = 0.0;

	/**
	 * Start the segment.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function start_segment() {
		$this->sample_size ++;
		$this->start_time = $this->get_milliseconds();
	}

	/**
	 * Stop the segment.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function stop_segment() {
		$this->total_times += $this->get_milliseconds() - $this->start_time;

		// Reset the start time.
		$this->start_time = 0.0;
	}

	/**
	 * Run the statistics on the profiles.
	 *
	 * @since 1.0.0
	 *
	 * @param float $baseline_avg_time The baseline's average time.
	 *
	 * @return void
	 */
	public function run_stats( $baseline_avg_time ) {
		$this->baseline        = $baseline_avg_time;
		$this->avg_time        = $this->total_times / $this->sample_size;
		$this->time_difference = $this->avg_time - $baseline_avg_time;

		$this->total_times = 0.0;
		$this->sample_size    = 0.0;
	}

	/**
	 * Get the property's value.
	 *
	 * @since 1.0.0
	 *
	 * @param string $property Property to get.
	 *
	 * @return mixed
	 */
	public function get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->$property;
		}
	}

	/**
	 * Get the milliseconds.
	 *
	 * @since 1.0.0
	 *
	 * @return float
	 */
	protected function get_milliseconds() {
		return microtime( true ) * 1000.0;
	}
}
