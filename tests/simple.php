<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/22
 * Time: 10:34
 */


require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// init, set the memory size unit
$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
// mark a
$timer->mark('a');
sleep(2);
// mark b
$timer->mark('b');
sleep(3);
// mark c
$timer->mark('c');
sleep(4);
// mark d
$timer->mark('d');
// print total report
$timer->printReport();
// get total report
$report = $timer->getReport();
// get the report of mark
$a_report = $timer->getReport('a');
print_r($a_report);
// get the diff report between a and b
$timer->printDiffReportByStartAndEnd('a', 'b');
// get the diff report between a and b
$ab_diff_report = $timer->getDiffReportByStartAndEnd('a', 'b');
// print the total diff report
$timer->printDiffReport();
// get the total diff report
$diff_report = $timer->getDiffReport();
// write the total report into the log file
$timer->logReport('/tmp/php-time.log1');
// write the diff report into the log file
$timer->logDiffReport('/tmp/php-time.log2');
// write the diff report between a and b into the log file
$timer->logDiffReportByStartAndEnd('/tmp/php-time.log3', 'a', 'b');
// print all diff report
$timer->printAllDiffReport();