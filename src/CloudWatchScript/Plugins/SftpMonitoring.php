<?php
namespace CloudWatchScript\Plugins;

use CloudWatchScript\AbstractMonitoring;

/**
 * Check Solr using ping URL.
 * Add and configure the following lines to the config file
 * "Sftp" : {
 *         "name" : "Name of metric and alarm",
 *         "addr": "127.0.0.1",
 *         "port": "22",
 *         "login": "login",
 *         "password": "password",
 *         "namespace": "Metric/Namespace",
 *         "description": "Description"
 * }
 */
class SftpMonitoring extends AbstractMonitoring
{
    private $addr;
    private $port;
    private $login;
    private $password;
    /**
     * @param array $config
     * @param String $name
     */
    public function __construct($config, $name)
    {
        parent::__construct($config, $name);
        $this->addr = $this->config->addr;
        $this->port = $this->config->port;
        $this->login = $this->config->login;
        $this->password = $this->config->password;
    }
    /**
     * Check solr ping url.
     * @return metric 0 KO, 1 OK
     */
    public function getMetric()
    {
        $connection = ssh2_connect($this->addr, $this->port);
        if ($connection === false) {
            return 0;
        }
        if (ssh2_auth_password($connection, $this->login, $this->password) == false) {
            return 0;
        }
        $sftp = ssh2_sftp($connection);
        if ($sftp === false) {
            return 0;
        }
        return 1;
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
