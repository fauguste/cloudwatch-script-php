<?php
$loader = require(realpath(dirname(__FILE__)) . '/../vendor/autoload.php');

// Add test source to composer autoloader
$loader->add('CloudWatchScript', "tests/src/");
