<?php
namespace CloudWatchScript;

abstract class AbstractMonitoring
{
    protected $config;
    /**
     *
     * @param array $config
     */
    function __construct($config) {
        $this->config = $config;

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
     * @return Alarm Threshold
     */
    abstract function getAlarmeThreshold();
    
    /**
     * @return Alarme Comparison Operator
     */
    abstract function getComparisonOperator();
}