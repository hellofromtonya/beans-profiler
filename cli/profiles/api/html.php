<?php
/**
 * HTML API functions to be profiled.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

/**
 * Setup the tasks before we run the Profiler.
 */
add_action( 'beans_profiler_setup_tasks', function() {
	add_action( 'beans_profiler_test_before_markup', function() {
		echo '<!-- beans_profiler_test_before_markup fired! -->';
	} );

	add_action( 'beans_profiler_test_prepend_markup', function() {
		echo '<!-- beans_profiler_test_prepend_markup fired! -->';
	} );
} );

/**
 * Clean up tasks before we exit the Profiler.
 */
add_action( 'beans_profiler_cleanup_tasks', function() {
	remove_all_actions( 'beans_profiler_test_before_markup' );
	remove_all_actions( 'beans_profiler_test_prepend_markup' );
} );

/**
 * Profile beans_add_attributes().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_add_attributes( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_add_attributes' );
	beans_add_attributes( 'beans_profiler_test', array( 'class' => 'uk-article-title' ) );
	$profiler->stop_segment( 'beans_add_attributes' );
}

/**
 * Profile beans_open_markup().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_open_markup( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_open_markup' );
	beans_open_markup( 'beans_profiler_test', 'h1', array( 'class' => 'uk-article-title' ) );
	$profiler->stop_segment( 'beans_open_markup' );
}
