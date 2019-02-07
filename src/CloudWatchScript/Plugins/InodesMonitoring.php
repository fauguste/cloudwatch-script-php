<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the following lines to the config file
 * "INodes" : {
 *         "name" : "INodes",
 *         "maxUsed": 90,
 *         "namespace": "Metric/INodes",
 *         "description": "Get INodes percentage current instance usage"
 * }
 */
class INodesMonitoring extends AbstractMonitoring
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
     * @return integer Percentage of used iNodes
     */
    public function getMetric()
    {
        $percent = exec("df -i / | grep '..%' -o | tail -1");
        $percent = preg_replace("/[^0-9]/", "", $percent);
        return (int)$percent;
    }

    /**
     * @return string "Percent"
     */
    public function getUnit()
    {
        return "Percent";
    }

    /**
     * @return array Alarm for max INodes used
     */
    public function getAlarms()
    {
        return array(
            array(
                "ComparisonOperator" => "GreaterThanThreshold",
                "Threshold" => $this->maxUsed,
                "Name" => $this->name . " exceed " . $this->config->maxUsed . " %"
            )
        );
    }
}
