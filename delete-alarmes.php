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

$client = getCloudWatchClient($conf);

$alarmsToDelete = [];

foreach ($conf->metrics as $metrics) {
    foreach ($metrics as $metricName => $metric) {
        $pluginName       = isset($metric->{'plugin'}) === true ? $metric->{'plugin'} : $metricName;
        $className        = "CloudWatchScript\\Plugins\\" . $pluginName . "Monitoring";
        $metricController = new $className($metric, $metric->name);
        foreach ($metricController->getAlarms() as $key => $alarm) {
            $alarmsToDelete[] = $alarm["Name"];
        }
    }
}

$client->deleteAlarms(array(
    'AlarmNames' => $alarmsToDelete
));
