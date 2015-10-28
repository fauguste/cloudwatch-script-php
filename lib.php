<?php

use Aws\CloudWatch\CloudWatchClient;

function getCloudWatchClient($conf) {
    if(isset($conf->aws->profil)) {
        return CloudWatchClient::factory(array(
            'profil' => $conf->aws->profil,
            'region' => $conf->aws->region,
            'version' => '2010-08-01'
        ));
    }
    else {
        return CloudWatchClient::factory(array(
            'credentials' => array (
                'key'    => $conf->aws->key,
                'secret' => $conf->aws->secret
            ),
            'region' => $conf->aws->region,
            'version' => '2010-08-01'
        ));
    }
} 

