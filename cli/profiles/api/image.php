<?php
/**
 * Image API functions to be profiled.
 *
 * @package Beans\Profiler\CLI
 *
 * @since   1.5.0
 */

namespace Beans\Profiler\CLI;

/**
 * Profile beans_edit_image() by running the full task of editing, creating, and saving a newly edited image.
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_edit_image_full( MicroProfiler $profiler ) {
	$image_src = realpath( __DIR__ . '/../../fixtures/image1.jpg' );
	$args      = array( 'resize' => array( 800, false ) );

	// Remove the edited image, if it exists.
	_remove_the_edited_image( $args );

	$profiler->start_segment( 'beans_edit_image FULL' );
	beans_edit_image( $image_src, $args, ARRAY_A );
	$profiler->stop_segment( 'beans_edit_image FULL' );

	// Remove the edited image file.
	_remove_the_edited_image( $args );
}

/**
 * Profile beans_edit_image() for processing when the edited image exists.
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_edit_image_existing( MicroProfiler $profiler ) {
	$image_src = realpath( __DIR__ . '/../../fixtures/image1.jpg' );
	$args      = array( 'resize' => array( 800, false ) );

	// If the edited image does not exist, create it.
	if ( ! file_exists( _get_edited_image_path( $args ) ) ) {
		beans_edit_image( $image_src, $args, ARRAY_A );
	}

	$profiler->start_segment( 'beans_edit_image EXISTING' );
	beans_edit_image( $image_src, $args, ARRAY_A );
	$profiler->stop_segment( 'beans_edit_image EXISTING' );
}

/**
 * Remove the edited image.
 *
 * @since 1.0.0
 *
 * @param array $args Array of arguments.
 *
 * @return void
 */
function _remove_the_edited_image( array $args ) {
	$edited_image_src = _get_edited_image_path( $args );

	if ( file_exists( $edited_image_src ) ) {
		@unlink( $edited_image_src );
	}
}

/**
 * Get the edited image's absolute path.
 *
 * @since 1.0.0
 *
 * @param array $args Array of arguments.
 *
 * @return string
 */
function _get_edited_image_path( array $args ) {
	static $edited_image_src;

	if ( ! $edited_image_src ) {
		$edited_image_src = sprintf( '%simage1-%s.jpg', beans_get_images_dir(), substr( md5( @serialize( $args ) ), 0, 7 ) ); // @codingStandardsIgnoreLine - Generic.PHP.NoSilencedErrors.Discouraged  This is a valid use case.
	}

	return $edited_image_src;
}
