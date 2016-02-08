<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Http" : {
 *         "name" : "Name of metric and alarm",
 *         "url": "http://localhost:8080/solr/collection1/admin/ping",
 *         "pattern": "ds",
 *         "namespace": "Metric/Namespace",
 *         "description": "Descrption"
 * }
 */
class HttpMonitoring extends AbstractMonitoring
{
    private $url;
    private $pattern;
    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->url = $this->config->url;
        $this->pattern = $this->config->pattern;
    }
    /**
     * Check solr ping url.
     * @return metric 0 Ok, 1 KO
     */
    public function getMetric()
    {
        $result = @file_get_contents($this->url);
        if ($result === false) {
            return 0;
        }
        return ereg($this->pattern, $result)==true?"1":"0";
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
                    array("ComparisonOperator" => "LessThanThreshold",
                          "Threshold" => 1,
                          "Name" => $this->name)
                    );
    }
}
