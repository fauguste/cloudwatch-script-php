<?php

namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check memory usage using free.
 * Add and configure the following lines in the config file
 * "Memory" : {
 *         "name" : "Name of metric and alarm",
 *         "maxUsed": 90,
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class MemoryMonitoring extends AbstractMonitoring
{
    private $maxUsed;

    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->maxUsed = $config->maxUsed;
    }

    /**
     * @return integer Percentage of use memory
     */
    public function getMetric()
    {
        $free     = shell_exec('free -m');
        $free     = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem      = explode(" ", $free_arr[1]);
        $mem      = array_filter($mem);
        $mem      = array_merge($mem);
        // ( Memory used / Total memory ) * 100
        return ($mem[2] / $mem[1]) * 100;
    }

    /**
     * @return string Metric unit
     */
    public function getUnit()
    {
        return "Percent";
    }

    /**
     * @return array Alarm max for memory used
     */
    public function getAlarms()
    {
        return array(
            array(
                "ComparisonOperator" => "GreaterThanThreshold",
                "Threshold" => $this->maxUsed,
                "Name" => $this->name . " exceed " . $this->maxUsed . " %"
            )
        );
    }
}
