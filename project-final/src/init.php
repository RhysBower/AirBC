<?php
ini_set("display_errors", 1);

ini_set("log_errors", 1);
ini_set("error_log", __DIR__.'/../logs/php.log');
date_default_timezone_set('America/Vancouver');

require  __DIR__ . '/../vendor/autoload.php';

switch ($_SERVER['REQUEST_URI']) {
    case "/":
        new Airbc\Controllers\HomeController();
        break;
    case "/routes":
        new Airbc\Controllers\RoutesController();
        break;
    case "/flights":
        new Airbc\Controllers\FlightsController();
        break;
    case "/airports":
        new Airbc\Controllers\AirportsController();
        break;
    case "/tickets":
        new Airbc\Controllers\TicketsController();
        break;
    case "/login":
        $controller = new Airbc\Controllers\AccountController();
        $controller->login();
        break;
    case "/logout":
        $controller = new Airbc\Controllers\AccountController();
        $controller->logout();
        break;
    case "/account":
        $controller = new Airbc\Controllers\AccountController();
        $controller->account();
        break;
    default:
        new Airbc\Controllers\Error404Controller();
}
