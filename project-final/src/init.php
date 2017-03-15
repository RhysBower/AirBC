<?php
ini_set("display_errors", 1);

ini_set("log_errors", 1);
ini_set("error_log", __DIR__.'/../logs/php.log');
date_default_timezone_set('America/Vancouver');

require  __DIR__ . '/../vendor/autoload.php';

use Airbc\Router\Router;
use Airbc\Router\Request;

$router = new Router();

$router->get("/", function (Request $request) {
    new Airbc\Controllers\HomeController();
});
$router->get("/routes", function (Request $request) {
    new Airbc\Controllers\RoutesController();
});
$router->get("/flights", function (Request $request) {
    new Airbc\Controllers\FlightsController();
});
$router->get("/airports", function (Request $request) {
    new Airbc\Controllers\AirportsController();
});
$router->get("/tickets", function (Request $request) {
    new Airbc\Controllers\TicketsController();
});
$router->get("/login", function (Request $request) {
    $controller = new Airbc\Controllers\AccountController();
    $controller->login();
});
$router->post("/login", function (Request $request) {
    $controller = new Airbc\Controllers\AccountController();
    $controller->login();
});
$router->get("/logout", function (Request $request) {
    $controller = new Airbc\Controllers\AccountController();
    $controller->logout();
});
$router->get("/account", function (Request $request) {
    $controller = new Airbc\Controllers\AccountController();
    $controller->account();
});

$router->error404(function (Request $request) {
    new Airbc\Controllers\Error404Controller();
});

$router->route($_SERVER['REQUEST_URI']);
