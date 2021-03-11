<?php

namespace CloudWatchScript;

abstract class AbstractMonitoring
{
    protected $config;
    protected $name;

    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        $this->config = $config;
        $this->name   = $name;
    }

    /**
     * @return string The metric
     */
    abstract public function getMetric();

    /**
     * (string: Seconds | Microseconds | Milliseconds | Bytes | Kilobytes | Megabytes | Gigabytes | Terabytes |
     *   Bits | Kilobits | Megabits | Gigabits | Terabits | Percent | Count | Bytes/Second | Kilobytes/Second |
     *   Megabytes/Second | Gigabytes/Second | Terabytes/Second | Bits/Second | Kilobits/Second | Megabits/Second |
     *   Gigabits/Second | Terabits/Second | Count/Second | None)
     * @return integer
     */
    abstract public function getUnit();

    /**
     * ComparisonOperator : GreaterThanOrEqualToThreshold | GreaterThanThreshold | LessThanThreshold |
     * LessThanOrEqualToThreshold
     * @return Array Array of alarm list. Each alarm contain ComparisonOperator, Threshold and Name
     */
    abstract public function getAlarms();

    /**
     * @param $alarmName Alarm name
     * @return String The metrics name associate to an alarm name.
     */
    public function getMetricName($alarmName)
    {
        return $this->name;
    }
}
