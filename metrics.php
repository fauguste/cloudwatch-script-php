<?php
define('APPLICATION_PATH', realpath(dirname(__FILE__)));

include APPLICATION_PATH . '/vendor/autoload.php';

use Aws\CloudWatch\CloudWatchClient;

// Load config file.
$conf = json_decode(file_get_contents(APPLICATION_PATH.'/conf/config.json'));
if($conf == false) {
    echo "Conf file is not valid";
    die();
}

// Store metric by namespace in order to call "AWS Could Watch" one time per namespace
$metricsToPush = array();

// Get Instance Id
$instanceId = file_get_contents("http://169.254.169.254/latest/meta-data/instance-id");

foreach ($conf->metrics as $metrics) {
    foreach($metrics as $metricName => $metric){
        $className = "CloudWatchScript\\Plugins\\" . $metricName . "Monitoring";

        $metricController = new $className($metric, $metricName);

        if(!array_key_exists($metric->namespace, $metricsToPush)) {
            $metricsToPush[$metric->namespace] = array();
        }
        
        $metricsToPush[$metric->namespace][] =  array(
                'MetricName' => $metric->name,
                'Timestamp'  => time(),
                'Value'      => $metricController->getMetric(),
                'Unit'       => $metricController->getUnit(),
                'Dimensions' => array(array('Name' => 'InstanceId', 'Value' => $instanceId), array('Name' => 'Metrics', 'Value' => $metricName))
        );
    }
}

$client = CloudWatchClient::factory(array(
        'key'    => $conf->aws->key,
        'secret' => $conf->aws->secret,
        'region' => $conf->aws->region
));

foreach ($metricsToPush as $namespace => $metricData) {
    $client->putMetricData(array(
            'Namespace'  =>$namespace,
            'MetricData' => $metricData
    ));
}
