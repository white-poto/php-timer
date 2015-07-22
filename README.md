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
//打印a状态和b状态的差异信息，包含运行时间、使用内存等
$timer->printDiffReportByStartAndEnd('a', 'b');
//获取第一个mark和最后一个mark之间的差异信息
$timer->printDiffReport();
```

输入结果如下  
```shell
------------------------------------------
mark:a
time:1437534443.7121s
memory_real:1280KB
memory_emalloc:830.4375KB
memory_peak_real:1280KB
memory_peak_emalloc:841.625KB
------------------------------------------
mark:b
time:1437534445.7123s
memory_real:1280KB
memory_emalloc:831.625KB
memory_peak_real:1280KB
memory_peak_emalloc:841.625KB
------------------------------------------
mark:c
time:1437534448.7125s
memory_real:1280KB
memory_emalloc:832.5859375KB
memory_peak_real:1280KB
memory_peak_emalloc:841.625KB
------------------------------------------
mark:d
time:1437534452.7127s
memory_real:1280KB
memory_emalloc:833.546875KB
memory_peak_real:1280KB
memory_peak_emalloc:841.625KB
------------------------------------------
mark:[diff] start_mark:a end_mark:b
time:2.0001969337463s
memory_real:0KB
memory_emalloc:1.1875KB
memory_peak_real:0KB
memory_peak_emalloc:0KB
------------------------------------------
mark:[total diff]
time:9.0006530284882s
memory_real:0KB
memory_emalloc:3.109375KB
memory_peak_real:0KB
memory_peak_emalloc:0KB
```