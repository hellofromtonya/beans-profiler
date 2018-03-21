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
 * Setup the tasks before we run the Profiler.
 */
add_action( 'beans_profiler_setup_tasks', function() {
	add_action( 'beans_profiler_actions_render_test', function() {
		echo '<!-- beans_profiler_actions_render_test fired! -->';
	} );
} );

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
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	_store_in_actions_container( 'added', 'beans_post_image', $action );

	$profiler->start_segment( '_beans_get_action' );
	_beans_get_action( 'beans_post_image', 'added' );
	$profiler->stop_segment( '_beans_get_action' );

	_beans_unset_action( 'beans_post_image', 'added' );
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
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	_store_in_actions_container( 'added', 'beans_post_image', $action );

	$profiler->start_segment( '_beans_set_action' );
	_beans_set_action( 'beans_post_image', $action, 'added', true );
	$profiler->stop_segment( '_beans_set_action' );

	_beans_unset_action( 'beans_post_image', 'added' );
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
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	_store_in_actions_container( 'added', 'beans_post_image', $action );

	$profiler->start_segment( '_beans_unset_action' );
	_beans_unset_action( 'beans_post_image', 'added' );
	$profiler->stop_segment( '_beans_unset_action' );
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
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	_store_in_actions_container( 'added', 'beans_post_image', $action );

	$action['priority'] = 10;
	$profiler->start_segment( '_beans_merge_action' );
	_beans_merge_action( 'beans_post_image', $action, 'added' );
	$profiler->stop_segment( '_beans_merge_action' );

	_beans_unset_action( 'beans_post_image', 'added' );
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
	$action = array(
		'hook'     => 'beans_post_body',
		'callback' => 'beans_post_image',
		'priority' => 5,
		'args'     => 1,
	);

	_store_in_actions_container( 'added', 'beans_post_image', $action );

	$profiler->start_segment( '_beans_get_current_action' );
	_beans_get_current_action( 'beans_post_image' );
	$profiler->stop_segment( '_beans_get_current_action' );

	_beans_unset_action( 'beans_post_image', 'added' );
}

/**
 * Profile _beans_render_action().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile__beans_render_action( MicroProfiler $profiler ) {
	$profiler->start_segment( '_beans_render_action' );
	_beans_render_action( 'beans_profiler_actions_render_test', array( 'class' => 'profiler-test' ) );
	$profiler->stop_segment( '_beans_render_action' );
}

/**
 * Store the action in the container.
 *
 * @since 1.0.0
 *
 * @param string $status The container status key.
 * @param string $id     The Beans ID.
 * @param array  $action The action to be stored.
 *
 * @return void
 */
function _store_in_actions_container( $status, $id, array $action ) {
	global $_beans_registered_actions;

	if ( 'beans-v1.4.0' === BEANS_PROFILER_THEME ) {
		$action = json_encode( $action );
	}

	$_beans_registered_actions[ $status ][ $id ] = $action;
}
