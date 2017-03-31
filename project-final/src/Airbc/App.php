<?php declare(strict_types=1);
namespace Airbc;

use Airbc\Router\Router;
use Airbc\Router\Request;

class App extends Object
{
    public function __construct()
    {
        if(array_key_exists('_method', $_POST)) {
            $_SERVER['REQUEST_METHOD'] = strtoupper($_POST['_method']);
        }
        Log::info($_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI']);

        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));

        $this->setupRoutes();
    }

    private function setupRoutes() {
        $router = new Router();

        $router->get("/", Controllers\HomeController::class, 'home');
        $router->get("/routes", Controllers\RoutesController::class, 'routes');
        $router->get("/routes/search/from/{departure}", Controllers\RoutesController::class, 'getRoutesFrom');
        $router->get("/routes/search/to/{arrival}", Controllers\RoutesController::class, 'getRoutesTo');
        $router->get("/routes/search/from/{departure}/to/{arrival}", Controllers\RoutesController::class, 'getRoute');
        $router->get("/routes/add", Controllers\RoutesController::class, 'renderAddRoutePage');
        $router->post("/routes/add", Controllers\RoutesController::class, 'addRoute');

        $router->get("/flights", Controllers\FlightsController::class, 'flights');
        $router->get("/flights/add", Controllers\FlightsController::class, 'renderAddFlightPage');
        $router->get("/flights/{id}", Controllers\FlightsController::class, 'getFlight');
        $router->get("/flights/search/from/{departure}", Controllers\FlightsController::class, 'getFlightsFrom');
        $router->get("/flights/search/to/{arrival}", Controllers\FlightsController::class, 'getFlightsFrom');
        $router->get("/flights/search/from/{departure}/to/{arrival}", Controllers\FlightsController::class, 'getFlightsOnRoute');
        $router->post("/flights/add", Controllers\FlightsController::class, 'addFlight');

        $router->get("/aircrafts", Controllers\AircraftsController::class, 'aircrafts');
        $router->get("/aircrafts/{id}", Controllers\AircraftsController::class, 'getAircraft');
        $router->get("/aircrafts/search/{input}/{selected}", Controllers\AircraftsController::class, 'aircraftsSearch');

        $router->get("/airports", Controllers\AirportsController::class, 'airports');
        $router->get("/airports/add", Controllers\AirportsController::class, 'renderAddAirportPage');
        $router->get("/airports/{id}", Controllers\AirportsController::class, 'getAirport');
        $router->get("/airports/search/{input}", Controllers\AirportsController::class, 'searchAirports');
        $router->post("/airports/add", Controllers\AirportsController::class, 'addAirport');
        $router->delete("/airports/{id}", Controllers\AirportsController::class, 'removeAirport');

        $router->get("/tickets", Controllers\TicketsController::class, 'tickets');
        $router->get("/tickets/book", Controllers\TicketsController::class, 'bookTicket');
        $router->get("/tickets/{id}", Controllers\TicketsController::class, 'getTicket'); //TODO
        $router->post("/tickets/book", Controllers\TicketsController::class, 'addTicket');
        $router->delete("/tickets/{id}", Controllers\TicketsController::class, 'removeTicket');

        $router->get("/login", Controllers\AccountController::class, 'login');
        $router->post("/login", Controllers\AccountController::class, 'login');
        $router->get("/logout", Controllers\AccountController::class, 'logout');
        $router->get("/account", Controllers\AccountController::class, 'account');
        $router->post("/account", Controllers\AccountController::class, 'updateAccount');
        $router->post("/account/password", Controllers\AccountController::class, 'updatePassword');
        $router->get("/account/new", Controllers\AccountController::class, 'newAccountPage');
        $router->post("/account/new", Controllers\AccountController::class, 'createAccount');

        $router->get("/staff", Controllers\StaffController::class, 'staff');
        $router->get("/staff/tickets/all", Controllers\StaffController::class, 'customersBookedAllFlights');
        $router->get("/staff/tickets/{aggregation}", Controllers\StaffController::class, 'ticketInfo');
        $router->get("/staff/routes/price", Controllers\StaffController::class, 'routePrice');
        $router->get("/staff/routes/count", Controllers\StaffController::class, 'flightsOnRoute');
        $router->get("/staff/airports/sum", Controllers\StaffController::class, 'priceFromToAirport');

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
