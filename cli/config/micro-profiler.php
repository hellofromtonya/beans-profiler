<?php
/**
 * Micro Profiler runtime configuration parameters.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

return array(

	/**
	 * The number of times to profile/exercise each function.
	 */
	'sample_size'          => 10000,

	/**
	 * The list of functions to profile.
	 *
	 * - The key is the function name.
	 * - The value is the profile function to call.
	 */
	'functions_to_profile' => array(
		'_beans_get_action'             => __NAMESPACE__ . '\profile__beans_get_action',
		'_beans_set_action'             => __NAMESPACE__ . '\profile__beans_set_action',
		'_beans_unset_action'           => __NAMESPACE__ . '\profile__beans_unset_action',
		'_beans_merge_action'           => __NAMESPACE__ . '\profile__beans_merge_action',
		'_beans_get_current_action'     => __NAMESPACE__ . '\profile__beans_get_current_action',
		'beans_add_smart_action'        => __NAMESPACE__ . '\profile_beans_add_smart_action',
		'beans_modify_action_priority'  => __NAMESPACE__ . '\profile_beans_modify_action_priority',
		'beans_replace_action_callback' => __NAMESPACE__ . '\profile_beans_replace_action_callback',
		'beans_remove_action'           => __NAMESPACE__ . '\profile_beans_remove_action',
		'beans_reset_action'            => __NAMESPACE__ . '\profile_beans_reset_action',
		'beans_add_filter'              => __NAMESPACE__ . '\profile_beans_add_filter',
		'beans_apply_filters'           => __NAMESPACE__ . '\profile_beans_apply_filters',
		'beans_has_filters'             => __NAMESPACE__ . '\profile_beans_has_filters',
	),
);
