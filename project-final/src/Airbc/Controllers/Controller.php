<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Object;
use Airbc\Database;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

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
    private $currentUser;
    protected $context;

    public function __construct()
    {
        $formatter = new LineFormatter(null, null, true);

        $stream = new StreamHandler(__DIR__.'/../../../logs/airbc.log', Logger::DEBUG);
        $stream->setFormatter($formatter);

        $this->logger = new Logger('Airbc');
        $this->logger->pushHandler($stream);

        $this->logger->info($_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);

        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));

        $this->database = new Database($this->logger);

        $this->loader = new \Twig_Loader_Filesystem('templates', __DIR__."/../../");
        $this->twig = new \Twig_Environment($this->loader, array('debug' => true));
        $this->context = [];
        if(array_key_exists('account', $_COOKIE)) {
            $this->verifyAccount($_COOKIE['account']);
        }
        $this->context['currentUser'] = $this->currentUser;
    }

    /**
     * Global exception handler for all uncaught exceptions.
     * These would normally trigger an error in PHP but are caught and logged.
     */
    public function exceptionHandler(\Throwable $exception)
    {
        $this->logger->alert("Uncaught exception: ".$exception->getMessage()." on line ".$exception->getLine()." in file ".$exception->getFile() . "\n".$exception->getTraceAsString());
    }
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if(error_reporting() === 0) {
            return true;
        }
        switch ($errno) {
            case E_USER_ERROR:
                $this->logger->alert("Uncaught error: [$errno] $errstr on line $errline in file $errfile");
                exit(1);
                break;
            case E_USER_WARNING:
                $this->logger->warning("Uncaught warning: [$errno] $errstr on line $errline in file $errfile");
                break;
            case E_USER_NOTICE:
                $this->logger->notice("Uncaught notice: [$errno] $errstr on line $errline in file $errfile");
                break;
            default:
                $this->logger->alert("Unknown error type: [$errno] $errstr on line $errline in file $errfile");
                break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }

    private function verifyAccount($jwt) {
        try {
            $decoded = JWT::decode($jwt, AccountController::KEY, array('HS256'));
            $this->currentUser = $this->database->getAccount($decoded->sub);
            $this->logger->info("Valid token used");
        } catch (SignatureInvalidException $e) {
            // Invalid token
            $this->logger->info("Invalid token used");
            setcookie('account', "", time()-1000);
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->currentUser !== null;
    }

    public function isPublic(): bool
    {
        return $this->currentUser === null;
    }

    public function isCustomer(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isCustomer = $this->database->isCustomer($id);
            return $isCustomer;
        } catch (Exception $e) {
            $this->logger->info($e->getMessage());
            return false;
        }
    }

    public function isLoyaltyMember(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isLoyaltyMember = $this->database->isLoyaltyMember($id);
            return $isLoyaltyMember;
        } catch (Exception $e) {
            $this->logger->info($e->getMessage());
            return false;
        }
    }

    public function isStaff(): bool
    {
        try {
            $id = $this->currentUser->id;
            $isStaff = $this->database->isStaff($id);
            return $isStaff;
        } catch (Exception $e) {
            $this->logger->info($e->getMessage());
            return false;
        }
    }

    public function renderForbidden() {
        http_response_code(403);
        $template = $this->twig->load('403.twig');
        echo $template->render($this->context);
    }
}
