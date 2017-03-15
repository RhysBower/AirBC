<?php
ini_set("display_errors", 1);

ini_set("log_errors", 1);
ini_set("error_log", __DIR__.'/../logs/php.log');
date_default_timezone_set('America/Vancouver');

require  __DIR__ . '/../vendor/autoload.php';

new Airbc\App();
