<?php declare(strict_types=1);
namespace Airbc;

use Airbc\Router\Router;
use Airbc\Router\Request;

class App extends Object
{
    public function __construct()
    {
        Log::info($_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);

        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));

        $this->setupRoutes();
    }

    private function setupRoutes() {
        $router = new Router();

        $router->get("/", Controllers\HomeController::class, 'home');
        $router->get("/routes", Controllers\RoutesController::class, 'routes');
        $router->get("/flights", Controllers\FlightsController::class, 'flights');
        $router->get("/airports", Controllers\AirportsController::class, 'airports');
        $router->get("/tickets", Controllers\TicketsController::class, 'tickets');
        $router->get("/bookTicket", Controllers\TicketsController::class, 'bookTicket');
        $router->get("/login", Controllers\AccountController::class, 'login');
        $router->post("/login", Controllers\AccountController::class, 'login');
        $router->get("/logout", Controllers\AccountController::class, 'logout');
        $router->get("/account", Controllers\AccountController::class, 'account');

        $router->error404(function (Request $request) {
            new Controllers\Error404Controller();
        });

        $router->route($_SERVER['REQUEST_URI']);
    }

    /**
     * Global exception handler for all uncaught exceptions.
     * These would normally trigger an error in PHP but are caught and logged.
     */
    public function exceptionHandler(\Throwable $exception)
    {
        Log::alert("Uncaught exception: ".$exception->getMessage()." on line ".$exception->getLine()." in file ".$exception->getFile() . "\n".$exception->getTraceAsString());
    }
    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (error_reporting() === 0) {
            return true;
        }
        switch ($errno) {
            case E_USER_ERROR:
                Log::alert("Uncaught error: [$errno] $errstr on line $errline in file $errfile");
                exit(1);
                break;
            case E_USER_WARNING:
                Log::warning("Uncaught warning: [$errno] $errstr on line $errline in file $errfile");
                break;
            case E_USER_NOTICE:
                Log::notice("Uncaught notice: [$errno] $errstr on line $errline in file $errfile");
                break;
            default:
                Log::alert("Unknown error type: [$errno] $errstr on line $errline in file $errfile");
                break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }
}
