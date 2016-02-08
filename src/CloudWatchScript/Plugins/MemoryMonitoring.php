<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
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
        $this->maxUsed = $this->config->maxUsed;
    }

    /**
     * @return integer Percentage of use memory
     */
    public function getMetric()
    {
        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        // ( Memory used - cached ) / Total memory
        return ( $mem[2] - $mem[6] )/$mem[1]*100;
    }

    /**
     * @return string "None"
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
                array("ComparisonOperator" => "GreaterThanThreshold",
                        "Threshold" => $this->maxUsed,
                        "Name" => $this->name . " exceed " . $this->config->maxUtil . " %")
        );
      }
  }
