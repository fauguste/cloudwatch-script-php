<?php

namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the following lines to the config file
 * "Solr" : {
 *         "name" : "Name of metric and alarm",
 *         "url": "http://localhost:8080/solr/collection1/admin/ping",
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class SolrMonitoring extends AbstractMonitoring
{
    private $solrPingUrl;

    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->solrPingUrl = $this->config->url;
    }

    /**
     * Check solr ping url.
     * @return metric 0 Ok, 1 KO
     */
    public function getMetric()
    {
        if (@file_get_contents($this->solrPingUrl) === false) {
            return 0;
        }
        return 1;
    }

    /**
     * @return string "None"
     */
    public function getUnit()
    {
        return "None";
    }

    /**
     * @return integer 1
     */
    public function getAlarms()
    {
        return array(
            array(
                "ComparisonOperator" => "LessThanThreshold",
                "Threshold" => 1,
                "Name" => $this->name
            )
        );
    }
}
