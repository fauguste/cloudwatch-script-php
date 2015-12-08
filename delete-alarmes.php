<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__)));

include APPLICATION_PATH . '/vendor/autoload.php';
require_once 'lib.php';

use Aws\CloudWatch\CloudWatchClient;

// Load config file.
$conf = getConfigFile();
if ($conf === false) {
    echo "Conf file is not valid";
    die();
}
// Store metric by namespace in order to call "AWS Could Watch" one time per namespace
$metricsToPush = array();

// Get Instance Id
$instanceId = file_get_contents("http://169.254.169.254/latest/meta-data/instance-id");

$client = getCloudWatchClient($conf);

foreach ($conf->metrics as $metrics) {
    foreach ($metrics as $metricName => $metric) {
        $pluginName = isset($metric->{'plugin'})===true?$metric->{'plugin'}:$metricName;
        $className = "CloudWatchScript\\Plugins\\" . $pluginName  . "Monitoring";

        $metricController = new $className($metric,  $metric->name);

        foreach ($metricController->getAlarms() as $key => $alarm) {
            $client->deleteAlarms(array(
                    'AlarmNames' => array($alarm["Name"])
            ));
        }
    }
}
