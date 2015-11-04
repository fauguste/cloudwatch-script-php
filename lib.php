<?php

use Aws\CloudWatch\CloudWatchClient;

function getCloudWatchClient($conf)
{
    if (isset($conf->aws->profil)) {
        return CloudWatchClient::factory(array(
            'profil' => $conf->aws->profil,
            'region' => $conf->aws->region,
            'version' => '2010-08-01'
        ));
    }
    return CloudWatchClient::factory(array(
        'credentials' => array (
            'key'    => $conf->aws->key,
            'secret' => $conf->aws->secret
        ),
        'region' => $conf->aws->region,
        'version' => '2010-08-01'
    ));
}

function getConfigFile()
{
    $longopts  = array(
      "required:"     // Valeur requise
    );
    if (array_key_exists('f', $args = getopt("f:", $longopts))) {
        return json_decode(file_get_contents($args['f']));
    }
    return json_decode(file_get_contents(APPLICATION_PATH.'/conf/config.json'));
}
