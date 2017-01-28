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

foreach ($conf->metrics as $metrics) {
    foreach ($metrics as $metricName => $metric) {
       $pluginName = isset($metric->{'plugin'})===true?$metric->{'plugin'}:$metricName;
        $className = "CloudWatchScript\\Plugins\\" . $pluginName  . "Monitoring";

        $metricController = new $className($metric, $metricName);

        if (!array_key_exists($metric->namespace, $metricsToPush)) {
            $metricsToPush[$metric->namespace] = array();
        }
        $metrics = $metricController->getMetric();
        if(is_array($metrics)) {
          $units = $metricController->getUnit();
          foreach ($metrics as $metricId => $value) {
            $metricsToPush[$metric->namespace][] =  array(
                    'MetricName' => $metric->name . " " . $metricId,
                    'Timestamp'  => time(),
                    'Value'      => $value,
                    'Unit'       => $units[$metricId],
                    'Dimensions' => array(
                                      array('Name' => 'InstanceId', 'Value' => $instanceId),
                                      array('Name' => 'Metrics', 'Value' => $metricName)
                                    )
            );
          }
        }
        else {
          $metricsToPush[$metric->namespace][] =  array(
                  'MetricName' => $metric->name,
                  'Timestamp'  => time(),
                  'Value'      => $metrics,
                  'Unit'       => $metricController->getUnit(),
                  'Dimensions' => array(
                                    array('Name' => 'InstanceId', 'Value' => $instanceId),
                                    array('Name' => 'Metrics', 'Value' => $metricName)
                                  )
          );
        }
    }
}

$client = getCloudWatchClient($conf);

foreach ($metricsToPush as $namespace => $metricData) {
    $client->putMetricData(array(
            'Namespace'  =>$namespace,
            'MetricData' => $metricData
    ));
}
