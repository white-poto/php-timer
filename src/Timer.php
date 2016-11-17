<?php
/**
 * @author Jenner <hyxm@qq.com>
 * @license MIT
 * @datetime 2015/7/22 10:06
 * @homepage http://www.huyanping.cn
 */

namespace Jenner;


class Timer
{
    /**
     * @var array runtime report
     */
    protected $report = array();

    /**
     * @var string memory size unit
     */
    protected $memory_unit;

    const UNIT_BYTE = 'Bytes';
    const UNIT_KB = 'KB';
    const UNIT_MB = 'MB';
    const UNIT_GB = 'GB';

    /**
     * @param string $memory_unit
     */
    public function __construct($memory_unit = Timer::UNIT_BYTE)
    {
        $this->memory_unit = $memory_unit;
    }

    /**
     * @param string $mark report mark
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
     * get report by mark
     *
     * @param null|string $mark
     * @return array if mark is null, return all report,
     * else return report of mark
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
     * get total diff report between the first
     * mark and the last mark
     *
     * @return array
     */
    public function getDiffReport()
    {
        $marks = array_keys($this->report);
        return $this->getDiffReportByStartAndEnd($marks[0], $marks[count($marks) - 1]);
    }

    /**
     * get diff report between start_mark and end_mark
     *
     * @param string $start_mark
     * @param string $end_mark
     * @return array
     */
    public function getDiffReportByStartAndEnd($start_mark, $end_mark)
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
     * Log report to file. If the mark is null,write all report into
     * the log file,else write the report of mark into the log file
     *
     * @param string $file
     * @param string|null $mark
     */
    public function logReport($file, $mark = null)
    {
        if (is_null($mark)) {
            foreach ($this->report as $mark => $report) {
                $this->logReportRecord($file, $mark, $report);
            }
            return;
        }

        if (!array_key_exists($mark, $this->report)) {
            throw new \LogicException('mask does not exists');
        }

        $this->logReportRecord($file, $mark, $this->report[$mark]);
    }

    /**
     * Write total diff report into the log file
     *
     * @param string $file
     */
    public function logDiffReport($file)
    {
        $diff_report = $this->getDiffReport();
        $mark = '[total diff]';
        $this->logReportRecord($file, $mark, $diff_report);
    }

    /**
     * Write the diff report between start_mark and end_mark
     * into the log file.
     *
     * @param string $file
     * @param string $start_mark
     * @param string $end_mark
     */
    public function logDiffReportByStartAndEnd($file, $start_mark, $end_mark)
    {
        $diff_report = $this->getDiffReportByStartAndEnd($start_mark, $end_mark);
        $mark = '[diff] start_mark:' . $start_mark . ' end_mark:' . $end_mark;
        $this->logReportRecord($file, $mark, $diff_report);
    }

    /**
     * Print the report. If mark is null, print total report,
     * else print the report of mark
     *
     * @param string|null $mark
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
     * Print the total report
     */
    public function printDiffReport()
    {
        $diff_report = $this->getDiffReport();
        $mark = '[total diff]';
        $this->printReportRecord($mark, $diff_report);
    }

    /**
     * Print the diff report between start_mark and end_mark
     *
     * @param string $start_mark
     * @param string $end_mark
     */
    public function printDiffReportByStartAndEnd($start_mark, $end_mark)
    {
        $diff_report = $this->getDiffReportByStartAndEnd($start_mark, $end_mark);
        $mark = '[diff] start_mark:' . $start_mark . ' end_mark:' . $end_mark;
        $this->printReportRecord($mark, $diff_report);
    }

    /**
     * get all diff report between all marks
     *
     * @return array
     */
    public function getAllDiffReport()
    {
        $diff_report = array();
        $pre = null;
        foreach ($this->report as $key => $value) {
            if (is_null($pre)) {
                $pre = $key;
                continue;
            }
            $cur_report = $this->getDiffReportByStartAndEnd($pre, $key);
            $diff_report[$pre . '-' . $key] = $cur_report;
        }

        return $diff_report;
    }

    /**
     * print all diff report between all marks
     */
    public function printAllDiffReport()
    {
        $pre = null;
        foreach ($this->report as $key => $value) {
            if (is_null($pre)) {
                $pre = $key;
                continue;
            }
            $this->printDiffReportByStartAndEnd($pre, $key);
        }
    }

    /**
     * Print the report of mark
     *
     * @param string $mark
     * @param array $report
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
     * Write the report of mark into the log file
     *
     * @param string $file
     * @param string $mark
     * @param array $report
     */
    protected function logReportRecord($file, $mark, $report)
    {
        if (!file_exists($file) && !touch($file)) {
            throw new \RuntimeException("file is not exists or can not be created");
        }

        if (!is_writable($file)) {
            throw new \RuntimeException("file is note writable");
        }

        $memory_rate = $this->getMemoryRate();
        $memory_unit = $this->memory_unit;
        $message = '------------------------------------------' . PHP_EOL;
        $message .= "mark:" . $mark . PHP_EOL
            . "time:" . $report['time'] . 's' . PHP_EOL
            . "memory_real:" . ($report['memory_real'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_emalloc:" . ($report['memory_emalloc'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_peak_real:" . ($report['memory_peak_real'] / $memory_rate) . $memory_unit . PHP_EOL
            . "memory_peak_emalloc:" . ($report['memory_peak_emalloc'] / $memory_rate) . $memory_unit . PHP_EOL;

        $write = file_put_contents($file, $message, FILE_APPEND);

        if ($write === false) {
            throw new \RuntimeException("write file failed");
        }
    }

    /**
     * get the memory size unit
     *
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
     * Get microsecond time
     *
     * @return array|mixed
     */
    protected function getTime()
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time [1] + $time [0];
        return $time;
    }

}