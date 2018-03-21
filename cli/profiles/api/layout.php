<?php
/**
 * Layout API functions to be profiled.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

/**
 * Profile beans_get_layout() by running the full task of editing, creating, and saving a newly edited image.
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_get_layout( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_get_layout' );
	beans_get_layout();
	$profiler->stop_segment( 'beans_get_layout' );
}

/**
 * Profile beans_get_layout_class() by running the full task of editing, creating, and saving a newly edited image.
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_get_layout_class( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_get_layout_class' );
	beans_get_layout_class( 'content' );
	$profiler->stop_segment( 'beans_get_layout_class' );
}
