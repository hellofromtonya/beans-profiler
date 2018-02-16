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
 * Profile beans_edit_image().
 *
 * @since 1.5.0
 *
 * @param MicroProfiler $profiler Instance of the Micro Profiler.
 *
 * @return void
 */
function profile_beans_edit_image( MicroProfiler $profiler ) {
	$image_src = realpath( __DIR__ . '/../../fixtures/image1.jpg' );
	$args      = array( 'resize' => array( 800, false ) );

	$profiler->start_segment( 'beans_edit_image' );
	beans_edit_image( $image_src, $args, ARRAY_A );
	$profiler->stop_segment( 'beans_edit_image' );

	// Remove the edited image file.
	_remove_the_edited_image( $args );
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
	static $edited_image_src;

	if ( ! $edited_image_src ) {
		$edited_image_src = sprintf( '%simage1-%s.jpg', beans_get_images_dir(), substr( md5( @serialize( $args ) ), 0, 7 ) ); // @codingStandardsIgnoreLine - Generic.PHP.NoSilencedErrors.Discouraged  This is a valid use case.
	}

	if ( file_exists( $edited_image_src ) ) {
		@unlink( $edited_image_src );
	}
}
