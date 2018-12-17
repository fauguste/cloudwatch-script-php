<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the following lines to the config file
 * "Inodes" : {
 *         "name" : "Name of metric and alarm",
 *         "maxUsed": 90,
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class InodesMonitoring extends AbstractMonitoring
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
        $percent = exec("df / -i | grep \'/$\' | grep '..%' -o");
        return (int)$percent;
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
                        "Name" => $this->name . " exceed " . $this->config->maxUsed . " %")
        );
      }
  }
