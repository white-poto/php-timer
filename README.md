# php-timer

php运行状态报告工具
-------------------
使用方法如下  
```php
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

//初始化，设置内存单位
$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
//记录a状态
$timer->mark('a');
sleep(2);
//记录b状态
$timer->mark('b');
sleep(3);
//记录c状态
$timer->mark('c');
sleep(4);
//记录d状态
$timer->mark('d');
//打印总体报告（不包含差值）
$timer->printReport();
//获取总体报告，返回数组
$report = $timer->getReport();
//获取一个mark的报告
$a_report = $timer->getReport('a');
print_r($a_report);
//打印a状态和b状态的差异信息，包含运行时间、使用内存等
$timer->printDiffReportByStartAndEnd('a', 'b');
//获取a状态和b状态的差异报告
$ab_diff_report = $timer->getDiffReportByStartAndEnd('a', 'b');
//打印第一个mark和最后一个mark之间的差异信息
$timer->printDiffReport();
//获取第一个mark和最后一个mark之间的差异信息
$diff_report = $timer->getDiffReport();
```

输入结果如下  
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