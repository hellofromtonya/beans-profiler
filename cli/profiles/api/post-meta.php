<?php
/**
 * Post Meta API functions to be profiled.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

/**
 * Profile beans_get_post_meta().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_get_post_meta( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_get_post_meta' );
	beans_get_post_meta( 'beans_layout' );
	$profiler->stop_segment( 'beans_get_post_meta' );
}
