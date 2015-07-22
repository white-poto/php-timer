<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/22
 * Time: 10:06
 */

namespace Jenner;


class Timer
{
    /**
     * @var array 报告
     */
    protected $report = array();

    /**
     * @var string 内存单位
     */
    protected $memory_unit;


    const UNIT_BYTE = 'Bytes';
    const UNIT_KB = 'KB';
    const UNIT_MB = 'MB';
    const UNIT_GB = 'GB';

    /**
     * @param string $memory_unit 内存单位
     */
    public function __construct($memory_unit = Timer::UNIT_BYTE)
    {
        $this->memory_unit = $memory_unit;
    }

    /**
     * 记录当前运行状态
     * @param string $mark
     */
    public function mark($mark = "default")
    {
        $report = array(
            'time' => $this->getTime(),
            'memory_real' => memory_get_usage(true),
            'memory_emalloc' => memory_get_usage(false),
            'memory_peak_real' => memory_get_peak_usage(true),
            'memory_peak_emalloc' => memory_get_peak_usage(false),
        );
        $this->report[$mark] = $report;
    }


    /**
     * 获取报告
     * @param null $mark
     * @return array
     */
    public function getReport($mark = null)
    {
        if (is_null($mark)) {
            return $this->report;
        }

        if (!array_key_exists($mark, $this->report)) {
            throw new \LogicException('mask does not exists');
        }

        return $this->report[$mark];
    }

    /**
     * 获取总体差异报告
     * @return array
     */
    public function getDiffReport()
    {
        $marks = array_keys($this->report);
        return $this->getDiffByStartAndEnd($marks[0], $marks[count($marks) - 1]);
    }

    /**
     * 根据开始mark和结束mark获取差异报告
     * @param $start_mark
     * @param $end_mark
     * @return array
     */
    public function getDiffByStartAndEnd($start_mark, $end_mark)
    {
        if (!array_key_exists($start_mark, $this->report)
            || !array_key_exists($end_mark, $this->report)
        ) {
            throw new \LogicException('mask does not exists');
        }

        $start_report = $this->report[$start_mark];
        $end_report = $this->report[$end_mark];

        $diff_report = array(
            'time' => $end_report['time'] - $start_report['time'],
            'memory_real' => $end_report['memory_real'] - $start_report['memory_real'],
            'memory_emalloc' => $end_report['memory_emalloc'] - $start_report['memory_emalloc'],
            'memory_peak_real' => $end_report['memory_peak_real'] - $start_report['memory_peak_real'],
            'memory_peak_emalloc' => $end_report['memory_peak_emalloc'] - $start_report['memory_peak_emalloc'],
        );

        return $diff_report;
    }

    /**
     * 打印总体差异报告
     */
    public function printDiffReport()
    {
        $diff_report = $this->getDiffReport();
        $mark = '[total diff]';
        $this->printReportRecord($mark, $diff_report);
    }

    /**
     * 打印开始mark和结束mark的差异报告
     * @param $start_mark
     * @param $end_mark
     */
    public function printDiffReportByStartAndEnd($start_mark, $end_mark)
    {
        $diff_report = $this->getDiffByStartAndEnd($start_mark, $end_mark);
        $mark = '[diff] start_mark:' . $start_mark . ' end_mark:' . $end_mark;
        $this->printReportRecord($mark, $diff_report);
    }

    /**
     * 打印报告
     * @param null $mark
     */
    public function printReport($mark = null)
    {
        if (is_null($mark)) {
            foreach ($this->report as $mark => $report) {
                $this->printReportRecord($mark, $report);
            }
            return;
        }

        if (!array_key_exists($mark, $this->report)) {
            throw new \LogicException('mask does not exists');
        }

        $this->printReportRecord($mark, $this->report[$mark]);
    }

    /**
     * 打印一条报告
     * @param $mark
     * @param $report
     */
    protected function printReportRecord($mark, $report)
    {
        $memory_rate = $this->getMemoryRate();
        $memory_unit = $this->memory_unit;
        echo '------------------------------------------' . PHP_EOL;
        echo "mark:" . $mark . PHP_EOL
            . "time:" . $report['time'] . 's' . PHP_EOL
            . "memory_real:" . ($report['memory_real'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_emalloc:" . ($report['memory_emalloc'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_peak_real:" . ($report['memory_peak_real'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_peak_emalloc:" . ($report['memory_peak_emalloc'] / $memory_rate) . $memory_unit . PHP_EOL;

    }

    /**
     * 获取内存单位
     * @return int
     */
    protected function getMemoryRate()
    {
        switch ($this->memory_unit) {
            case Timer::UNIT_BYTE :
                return 1;
            case Timer::UNIT_KB :
                return 1024;
            case Timer::UNIT_MB :
                return 1024 * 1024;
            case Timer::UNIT_GB :
                return 1024 * 1024 * 1024;
            default :
                throw new \LogicException('unknown memory unit');
        }
    }

    /**
     * 获取当前微秒时间
     * @return String Time
     */
    protected function getTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time [1] + $time [0];
        return $time;
    }

}