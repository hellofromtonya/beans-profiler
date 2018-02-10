# Beans Profiler

This plugin provides a micro profiler to measure the current execution time of each function being profiled against a baseline.  

Why?  When we make changes to the codebase, we want to measure if those changes impacted its execution time.

How do we do that? We capture the results of the affected function/code _before_ we make changes.  This is our baseline.  Then you make your changes and run the profiler.  It will exercise the new code and compute it's average execution time in milliseconds.  That time is then compared to the original baseline.

NOTE: This plugin is in development.

## How to Run

We use composer to run the profiler.  When you initiate it, be patient, as it takes a couple of minutes to run.  Why? We are running 10,000 cycles for each profiled function in order to gather a proper sample and average.

1. Run the baseline profiles first by typing the following in the command line app: `composer run-baseline-profiler`.
2. Run the new code's profiles by typing the following in the command line app: `composer run-profiler`.
