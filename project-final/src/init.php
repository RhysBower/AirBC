<?php
ini_set("display_errors", 1);

ini_set("log_errors", 1);
ini_set("error_log", __DIR__.'/../logs/php.log');
date_default_timezone_set('America/Vancouver');

require  __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('Airbc');
$logger->pushHandler(new StreamHandler(__DIR__.'/../logs/airbc.log', Logger::DEBUG));
$logger->info('Load page: ' . $_SERVER['REQUEST_URI']);

$airbc = new Airbc\App($logger);

$loader = new Twig_Loader_Filesystem('templates', __DIR__);
$twig = new Twig_Environment($loader, array('debug' => true));
