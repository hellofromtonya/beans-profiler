
=================
The following functions were invoked <?php echo number_format( $this->sample_size ); ?> times during this micro profiler process.

	1. The 'time' column shows the function's average execution time in milliseconds (ms).


 --------------------------------   -------------
| Name                             | Avg Time     |
|                                  | (ms)         |
| -------------------------------- | ------------ |
<?php
foreach ( $this->profiles as $name => $profile ) {
	printf( "| %-30s   |    %0.6f  |\n", $name, $profile->get( 'avg_time' ) ); // @codingStandardsIgnoreLine.
}
?>
 --------------------------------   -------------
