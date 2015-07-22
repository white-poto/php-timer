<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/22
 * Time: 10:34
 */


require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$timer = new \Jenner\Timer();
$timer->mark('a');
sleep(2);
$timer->mark('b');
sleep(3);
$timer->mark('c');
sleep(4);
$timer->mark('d');
$timer->printReport();