<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Solr" : {
 *         "name" : "Name of metric and alarm", 
 *         "url": "http://localhost:8080/solr/collection1/admin/ping", 
 *         "namespace": "Metric/Namespace", 
 *         "description": "Descrption"
 * }
 */
class SolrMonitoring extends AbstractMonitoring
{
    private $solrPingUrl;
    /**
     * @param array $config
     */
    function __construct($config) {
       parent::__construct($config);
       $this->solrPingUrl = $this->config->url;
    }
    /**
     * Check solr ping url.
     * @return metric 0 Ok, 1 KO
     */
    public function getMetric() {
        if(file_get_contents($this->solrPingUrl) === false) {
            return 0;
        }
        else {
            return 1;
        }
    }
    /**
     * @return "None"
     */
    public function getUnit() {
        return "None";
    }
    /**
     * @return 1
     */
    public function getAlarmeThreshold() {
        return 1;
    }
    /**
     * @return LessThanThreshold
     */
    public function getComparisonOperator() {
        return "LessThanThreshold";
    }
}