<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Object;
use Airbc\Database;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;

/**
 * Base controller for pages.
 * Configures logging, database connection, and Twig.
 * Page controllers should extend this class and implement page specific functionality.
 */
class Controller extends Object
{
    protected $logger;
    protected $database;
    protected $loader;
    protected $twig;

    public function __construct()
    {
        $formatter = new LineFormatter(null, null, true);

        $stream = new StreamHandler(__DIR__.'/../../../logs/airbc.log', Logger::DEBUG);
        $stream->setFormatter($formatter);

        $this->logger = new Logger('Airbc');
        $this->logger->pushHandler($stream);

        $this->logger->info('Load page: ' . $_SERVER['REQUEST_URI']);

        set_exception_handler(array($this, 'exceptionHandler'));

        $this->database = new Database($this->logger);

        $this->loader = new \Twig_Loader_Filesystem('templates', __DIR__."/../../");
        $this->twig = new \Twig_Environment($this->loader, array('debug' => true));
    }

    /**
     * Global exception handler for all uncaught exceptions.
     * These would normally trigger an error in PHP but are caught and logged.
     */
    public function exceptionHandler($exception)
    {
        $this->logger->alert("Uncaught exception: " . $exception->getMessage());
    }
}
