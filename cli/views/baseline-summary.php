
-------------------------
MICRO PROFILER REPORT:
-------------------------

PHP version:        <?php echo phpversion() . "\n"; ?>
Sample Size:        <?php echo number_format( $this->sample_size ); ?> (per function)
Time Increments:    milliseconds, where 1 ms equals 0.0001 second.

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

NOTES:

1. The functions were invoked/exercised <?php echo number_format( $this->sample_size ); ?> times during this micro profiler process.
2. The 'time' column shows the function's average execution time.
