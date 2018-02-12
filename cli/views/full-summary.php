
-------------------------
MICRO PROFILER REPORT:
-------------------------

PHP version:        <?php echo phpversion() . "\n"; ?>
Sample Size:        <?php echo number_format( $this->sample_size ); ?> (per function)
Time Increments:    milliseconds, where 1 ms equals 0.001 second.

  --------------------------------   -------------   -------------   -------------
| Name                             | Result        |  Avg Time     | v1.4.0
|                                  | (ms)          |  (ms)         | (ms)
| -------------------------------- | ------------- | ------------- | -------------
<?php
foreach ( $this->profiles as $name => $profile ) {
	$this->print_segment( $name, $profile );
}
?>
 --------------------------------   -------------   -------------   -------------

NOTES:

1. The functions were invoked/exercised <?php echo number_format( $this->sample_size ); ?> times during this micro profiler process.
2. The 'diff' column = 'time' - 'v1.4.0'.
3. The 'time' column shows the function's average execution time.
4. 'v1.4.0' shows the same micro-profiler run on Beans v1.4.0.
