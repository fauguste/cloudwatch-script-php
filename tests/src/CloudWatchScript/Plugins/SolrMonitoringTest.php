<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractTestMonitoring;
use CloudWatchScript\Plugins\SolrMonitoring;

/**
 * Check Solr using ping URL.
 */
class SolrMonitoringTest extends AbstractTestMonitoring
{

    /**
     *
     */
    public function __construct()
    {
        $config = <<<EOT
{
        "name" : "Name of metric and alarm",
        "url": "http://localhost:8983/solr/admin/cores",
        "namespace": "Metric/Namespace",
        "description": "Descrption"
}
EOT;
        parent::__construct(new SolrMonitoring(json_decode($config), "Solr"));
    }

    /**
     * @return "None"
     */
    public function getUnit()
    {
        return "None";
    }
    /**
     * Get metric abstact test function.
     */
    public function getMetric()
    {
        return 1;
    }
}
