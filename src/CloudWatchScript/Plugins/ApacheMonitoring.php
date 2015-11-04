<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Apache" : {
 *         "name" : "Name of metric and alarm",
 *         "maxProcess": 100,
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class ApacheMonitoring extends AbstractMonitoring
{
    private $maxApacheProcess;

    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->maxApacheProcess = $this->config->maxProcess;
    }

    /**
     * @return integer Number of apache processus
     */
    public function getMetric()
    {
        exec('ps aux | grep apache', $output);
        return count($output);

    }
    /**
     * @return string "None"
     */
    public function getUnit()
    {
        return "None";
    }

    /**
     * @return array Alarm min and max for number of apache process
     */
    public function getAlarms()
    {
        return array(
                array("ComparisonOperator" => "LessThanOrEqualToThreshold",
                        "Threshold" => 0,
                        "Name" => $this->name . " shutdown"),
                array("ComparisonOperator" => "GreaterThanThreshold",
                        "Threshold" => $this->maxApacheProcess,
                        "Name" => $this->name . " max process")
        );
    }
}
