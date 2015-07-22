<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/22
 * Time: 10:34
 */


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