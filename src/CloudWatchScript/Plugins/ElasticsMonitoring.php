<?php

namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Elastics" : {
 *         "name" : "Name of metric and alarm",
 *         "url": "http://127.0.0.1:9200/_cluster/health",
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class ElasticsMonitoring extends AbstractMonitoring
{
    private $elasticsUrl;

    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->elasticsUrl = $this->config->url;
    }

    /*
     * Check Elastics health check
     * @return array
     */
    public function getMetric()
    {
        $elasticsCheck = @file_get_contents($this->elasticsUrl);
        if ($elasticsCheck === false) {
            return 0;
        }
        $elasticsCheck = json_decode($elasticsCheck, true);
        $status        = array("green" => 2, "yellow" => 1, "red" => 0);
        return array(
            "status" => $status[$elasticsCheck['status']],
            "number_of_nodes" => $elasticsCheck['number_of_nodes'],
            "number_of_data_nodes" => $elasticsCheck['number_of_data_nodes'],
            "active_primary_shards" => $elasticsCheck['active_primary_shards'],
            "active_shards" => $elasticsCheck['active_shards'],
            "unassigned_shards" => $elasticsCheck['unassigned_shards'],
            "active_shards_percent_as_number" => $elasticsCheck['active_shards_percent_as_number']
        );
    }

    /**
     * @return array
     */
    public function getUnit($alarmName = null)
    {
        if ($alarmName === null) {
            return array(
                "status" => "None",
                "number_of_nodes" => "Count",
                "number_of_data_nodes" => "Count",
                "active_primary_shards" => "Count",
                "active_shards" => "Count",
                "unassigned_shards" => "Count",
                "active_shards_percent_as_number" => "Percent"
            );
        }
        switch ($alarmName) {
            case $this->name . " status error":
            case $this->name . " status warning":
                return "None";
        }
    }

    /**
     * @return integer 1
     */
    public function getAlarms()
    {
        return array(
            array(
                "ComparisonOperator" => "LessThanThreshold",
                "Threshold" => 2,
                "Name" => $this->name . " status warning"
            ),
            array(
                "ComparisonOperator" => "LessThanThreshold",
                "Threshold" => 1,
                "Name" => $this->name . " status error"
            )
        );
    }

    /**
     * @param $alarmName Alarm name
     * @return string Metrics name associate to an alarm name.
     */
    public function getMetricName($alarmName)
    {
        switch ($alarmName) {
            case $this->name . " status error":
            case $this->name . " status warning":
                return $this->name . " status";
        }
    }
}
