<?php
ini_set("display_errors", 1);

ini_set("log_errors", 1);
ini_set("error_log", __DIR__.'/../logs/php.log');
date_default_timezone_set('America/Vancouver');

require  __DIR__ . '/../vendor/autoload.php';

switch($_SERVER['REQUEST_URI']) {
    case "/":
        new Airbc\Controllers\HomeController();
        break;
    case "/routes":
        new Airbc\Controllers\RoutesController();
        break;
    case "/flights":
        new Airbc\Controllers\FlightsController();
        break;
    default:
        new Airbc\Controllers\Error404Controller();
}
