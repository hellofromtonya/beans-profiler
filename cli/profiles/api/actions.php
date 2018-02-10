<?php
/**
 * Actions API functions to be profiled.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

/**
 * Profile beans_add_smart_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_add_smart_action( MicroProfiler $profiler ) {
	$profiler->start_segment( 'beans_add_smart_action' );
	beans_add_smart_action( 'beans_header', __FUNCTION__, 15, 3 );
	$profiler->stop_segment( 'beans_add_smart_action' );

	remove_action( 'beans_header', __FUNCTION__, 15 );
}

/**
 * Profile beans_modify_action_priority().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_modify_action_priority( MicroProfiler $profiler ) {
	$id = __FUNCTION__;
	beans_add_smart_action( 'beans_header', $id, 15, 3 );

	$profiler->start_segment( 'beans_modify_action_priority' );
	beans_modify_action_priority( $id, 4 );
	$profiler->stop_segment( 'beans_modify_action_priority' );

	remove_action( 'beans_header', $id, 4 );
}

/**
 * Profile beans_replace_action_callback().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_replace_action_callback( MicroProfiler $profiler ) {
	$id = __FUNCTION__;
	beans_add_smart_action( 'beans_header', $id, 15, 3 );

	$profiler->start_segment( 'beans_replace_action_callback' );
	beans_replace_action_callback( $id, 'beans_loop_query_args_base' );
	$profiler->stop_segment( 'beans_replace_action_callback' );

	remove_action( 'beans_header', 'beans_loop_query_args_base', 15 );
}

/**
 * Profile beans_remove_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_remove_action( MicroProfiler $profiler ) {
	$id = __FUNCTION__;
	beans_add_smart_action( 'beans_header', $id, 15, 3 );

	$profiler->start_segment( 'beans_remove_action' );
	beans_remove_action( $id );
	$profiler->stop_segment( 'beans_remove_action' );
}

/**
 * Profile beans_reset_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_reset_action( MicroProfiler $profiler ) {
	$id = __FUNCTION__;
	beans_add_smart_action( 'beans_header', $id, 15, 3 );
	beans_replace_action_callback( $id, 'beans_loop_query_args_base' );

	$profiler->start_segment( 'beans_reset_action' );
	beans_reset_action( $id );
	$profiler->stop_segment( 'beans_reset_action' );

	remove_action( 'beans_header', $id, 15 );
}

/**
 * Profile _beans_get_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_get_action( MicroProfiler $profiler ) {
	global $_beans_registered_actions;
	$action                                                 = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);
	$_beans_registered_actions['added']['beans_post_image'] = wp_json_encode( $action );

	$profiler->start_segment( '_beans_get_action' );
	_beans_get_action( 'beans_post_image', 'added' );
	$profiler->stop_segment( '_beans_get_action' );

	$_beans_registered_actions['added'] = array();
}

/**
 * Profile _beans_set_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_set_action( MicroProfiler $profiler ) {
	global $_beans_registered_actions;
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	$profiler->start_segment( '_beans_set_action' );
	_beans_set_action( 'beans_post_image', $action, 'added', true );
	$profiler->stop_segment( '_beans_set_action' );

	$_beans_registered_actions['added'] = array();
}

/**
 * Profile _beans_unset_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_unset_action( MicroProfiler $profiler ) {
	global $_beans_registered_actions;
	$action                                                 = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);
	$_beans_registered_actions['added']['beans_post_image'] = wp_json_encode( $action );

	$profiler->start_segment( '_beans_unset_action' );
	_beans_unset_action( 'beans_post_image', 'added' );
	$profiler->stop_segment( '_beans_unset_action' );

	$_beans_registered_actions['added'] = array();
}

/**
 * Profile _beans_merge_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_merge_action( MicroProfiler $profiler ) {
	global $_beans_registered_actions;
	$action                                                 = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);
	$_beans_registered_actions['added']['beans_post_image'] = wp_json_encode( $action );

	$action['priority'] = 10;
	$profiler->start_segment( '_beans_merge_action' );
	_beans_merge_action( 'beans_post_image', $action, 'added' );
	$profiler->stop_segment( '_beans_merge_action' );

	$_beans_registered_actions['added'] = array();
}

/**
 * Profile _beans_get_current_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_get_current_action( MicroProfiler $profiler ) {
	global $_beans_registered_actions;
	$action                                                 = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);
	$_beans_registered_actions['added']['beans_post_image'] = wp_json_encode( $action );

	$profiler->start_segment( '_beans_get_current_action' );
	_beans_get_current_action( 'beans_post_image' );
	$profiler->stop_segment( '_beans_get_current_action' );

	$_beans_registered_actions['added'] = array();
}
