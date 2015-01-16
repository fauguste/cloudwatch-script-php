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
    function __construct($config, $name) {
        $this->config = $config;
        $this->name = $name;
    }
    /**
     * @return an array with metric
     */
    abstract public function getMetric();
    /**
     * @return (string: Seconds | Microseconds | Milliseconds | Bytes | Kilobytes | Megabytes | Gigabytes | Terabytes | Bits | Kilobits | Megabits | Gigabits | Terabits | Percent | Count | Bytes/Second | Kilobytes/Second | Megabytes/Second | Gigabytes/Second | Terabytes/Second | Bits/Second | Kilobits/Second | Megabits/Second | Gigabits/Second | Terabits/Second | Count/Second | None)
     */
    abstract public function getUnit();
    /**
     * ComparisonOperator : GreaterThanOrEqualToThreshold | GreaterThanThreshold | LessThanThreshold | LessThanOrEqualToThreshold
     * @return Array Array of alarm list. Each alamr contain ComparisonOperator, Threshold and Name
     */
    abstract function getAlarms();
}