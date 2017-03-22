<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the folliwong lines to the config file
 * "Solr" : {
 *         "name" : "Name of metric and alarm",
 *         "url": "http://localhost:8080/solr/collection1/",
 *         "namespace": "Metric/Namespace",
 *         "description": "Descrption"
 * }
 */
class SolrCdcrMonitoring extends AbstractMonitoring
{
    private $solrUrl;
    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->solrUrl = $this->config->url;
    }
    /**
     * Check solr cdcr : queue size, process and buffer.
     * @return metric 0 Ok, 1 KO
     */
    public function getMetric()
    {
        $queue = -1;
        $process = 0;
        $buffer = 0;
        $cdcrQueues = @file_get_contents($this->solrUrl . "cdcr?action=QUEUES&wt=json");
        if($cdcrQueues !== false) {
            $cdcrQueues = json_decode($cdcrQueues, true);
            $queue = $cdcrQueues['queues'][1][1][1];
        }
        $cdcrStatus = @file_get_contents($this->solrUrl . "cdcr?action=STATUS&wt=json");
        if($cdcrStatus !== false) {
            $cdcrStatus = json_decode($cdcrStatus, true);
            $process = $cdcrStatus['status'][1]==='started'?1:0;
            $buffer = $cdcrStatus['status'][3]==='enabled'?1:0;
        }

        return array('queue' => $queue, 'process'=> $process, 'buffer' => $buffer);
    }

    public function getUnit($alarmName=null)
    {
         if($alarmName === null) {
           return array('queue' => 'Count', 'process' => 'None', 'buffer' => 'None');
         }
         else {
           switch ($alarmName) {
             case $this->name . " synchronisation stop":
               return "Count";
             case $this->name . " synchronisation delay (1000)":
               return "Count";
             case $this->name . " buffer":
               return "None";
             case $this->name . " process":
               return "None";
           }
         }
    }
    /**
     * Alarm if :
     * - queue size set to -1
     * - queue size great than 1000
     * - process is not started
     * - buffer is not enabled
     */
    public function getAlarms()
    {
        return array(
                    array("ComparisonOperator" => "LessThanThreshold",
                          "Threshold" => -1,
                          "Name" => $this->name . " synchronisation stop"
                    ),
                    array("ComparisonOperator" => "GreaterThanThreshold",
                          "Threshold" => 1000,
                          "Name" => $this->name . " synchronisation delay (1000)"
                    ),
                    array("ComparisonOperator" => "LessThanThreshold",
                          "Threshold" => 1,
                          "Name" => $this->name . " process"
                    ),
                    array("ComparisonOperator" => "LessThanThreshold",
                          "Threshold" => 1,
                          "Name" => $this->name . " buffer"
                    )
        );
    }
    public function getMetricName($alarm) {
      switch ($alarm) {
        case $this->name . " synchronisation stop":
          return $this->name . " queue";
        case $this->name . " synchronisation delay (1000)":
          return $this->name . " queue";
        case $this->name . " buffer":
          return $this->name . " buffer";
        case $this->name . " process":
          return $this->name . " process";
      }
   }
}
