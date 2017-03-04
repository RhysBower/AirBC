<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Object;
use Airbc\Database;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Controller extends Object
{
    protected $logger;
    protected $database;
    protected $loader;
    protected $twig;

    public function __construct()
    {
        $this->logger = new Logger('Airbc');
        $this->logger->pushHandler(new StreamHandler(__DIR__.'/../../../logs/airbc.log', Logger::DEBUG));
        $this->logger->info('Load page: ' . $_SERVER['REQUEST_URI']);

        set_exception_handler(array($this, 'exception_handler'));

        $this->database = new Database($this->logger);

        $this->loader = new \Twig_Loader_Filesystem('templates', __DIR__."/../../");
        $this->twig = new \Twig_Environment($this->loader, array('debug' => true));
    }

    public function exception_handler($exception)
    {
        $this->logger->alert("Uncaught exception: " . $exception->getMessage());
    }
}
