<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Disk" : {
 *         "name" : "Name of metric and alarm",
 *         "partition" : "/"
 *         "maxUtil": 90,
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class DiskMonitoring extends AbstractMonitoring
{
    private $maxUtil;
    private $partition;

    /**
     * @param array $config
     * @param String $name
     */
    function __construct($config, $name) {
       parent::__construct($config, $name);
       $this->maxUtil = $this->config->maxUtil;
       $this->partition = $this->config->partition;
    }

    /**
     * @return integer Percentage of use disk space
     */
    public function getMetric() {
        return 100 -  intval(100 * ( disk_free_space($this->partition) / disk_total_space($this->partition)));

    }
    /**
     * @return string "None"
     */
    public function getUnit() {
        return "Percent";
    }

    /**
     * @return array Alarm min and max for number of apache process
     */
    public function getAlarms() {
        return array(
                array("ComparisonOperator" => "GreaterThanThreshold",
                        "Threshold" => $this->maxUtil,
                        "Name" => $this->name . " exceed " . $this->config->maxUtil . " %")
        );
    }
}
