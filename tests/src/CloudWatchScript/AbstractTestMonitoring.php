<?php
namespace CloudWatchScript;

use \PHPUnit_Framework_TestCase;

abstract class AbstractTestMonitoring extends PHPUnit_Framework_TestCase
{
    protected $name;
    
    /**
     * @param Plugin $name
     */
    function __construct( $plugin) {
        $this->plugin = $plugin;
    }
    
    /**
     * Get unit abstact test function. 
     */
    abstract public function getUnit();
    /**
     * Get metric abstact test function.
     */
    abstract public function getMetric();
    /**
     * Test get Metrics fonction.
     */
    public function testGetUnit() {
        $this->assertEquals($this->plugin->getUnit(), $this->getUnit(), "Plugin unit doesn't match.");
    }
    
    /**
     * Test get Metrics fonction.
     */
    public function testTestMetric() {
        $this->assertEquals($this->plugin->getMetric(), $this->getMetric(), "Metrics doesn't match.");
    }
}