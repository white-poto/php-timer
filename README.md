php-timer
================
php runtime status report tool

Import
----------------
```shell
composer require jenner/timer
```
Or  
```php
require /path/to/php-time/src/Time.php
```

What it can do?
-------------
```php
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
```

result:  
```shell
------------------------------------------
mark:a
time:1437535424.9998s
memory_real:1280KB
memory_emalloc:833.046875KB
memory_peak_real:1280KB
memory_peak_emalloc:843.2890625KB
------------------------------------------
mark:b
time:1437535427s
memory_real:1280KB
memory_emalloc:834.2265625KB
memory_peak_real:1280KB
memory_peak_emalloc:843.2890625KB
------------------------------------------
mark:c
time:1437535430.0002s
memory_real:1280KB
memory_emalloc:835.1875KB
memory_peak_real:1280KB
memory_peak_emalloc:843.2890625KB
------------------------------------------
mark:d
time:1437535434.0004s
memory_real:1280KB
memory_emalloc:836.1484375KB
memory_peak_real:1280KB
memory_peak_emalloc:843.2890625KB
Array
(
    [time] => 1437535424.9998
    [memory_real] => 1310720
    [memory_emalloc] => 853040
    [memory_peak_real] => 1310720
    [memory_peak_emalloc] => 863528
)
------------------------------------------
mark:[diff] start_mark:a end_mark:b
time:2.0001850128174s
memory_real:0KB
memory_emalloc:1.1796875KB
memory_peak_real:0KB
memory_peak_emalloc:0KB
------------------------------------------
mark:[total diff]
time:9.0006000995636s
memory_real:0KB
memory_emalloc:3.1015625KB
memory_peak_real:0KB
memory_peak_emalloc:0KB
```