<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Routes page.
 */
class RoutesController extends Controller
{
    public function getRoutes($routes, $search) {
        $this->context['page'] = "routes";
        $routeAirports = [];
        foreach ($routes as $route) {
            $departureArrival = $route->getDepartureArrival();
            if (!is_null($departureArrival))
                $routeAirports[] = $departureArrival;
        }
        $this->context['routes'] = $routes;
        $this->context['routeAirports'] = $routeAirports;
        $this->context['search'] = $search; 
        $template = $this->twig->load('routes.twig');
        echo $template->render($this->context);
    }

    public function routes()
    {
        $routes = $this->database->getRoutes();
        $this->getRoutes($routes, null);
    }

    public function getRoute($departure, $arrival)
    {
        $routes = [];
        $route = $this->database->getRoute($departure, $arrival);
        if (!is_null($route)) $routes[] = $route;
        $this->getRoutes($routes, "From " . strtoupper($departure) . " to " . strtoupper($arrival) . ":");
    }

    public function getRoutesFrom($departure)
    {
        $routes = $this->database->getRoutesFrom($departure);
        $this->getRoutes($routes, "From " . strtoupper($departure) . ":");
    }

    public function getRoutesTo($arrival)
    {
        $routes = $this->database->getRoutesTo($arrival);
        $this->getRoutes($routes, "To " . strtoupper($arrival). ":"); 
    }

    public function renderAddRoutePage()
    {
        if($this->isStaff()){
            $this->context['page'] = "routes";
            $template = $this->twig->load('routes_add.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }

    public function renderError() {
        $template = $this->twig->load('routes_add.twig');
        echo $template->render($this->context);
    }

    public function addRoute()
    {
        // check if user is staff. 
        if($this->isStaff()) {
            $this->context['page'] = "routes";
            
            if (array_key_exists('departure', $_POST) && $_POST['departure'] !== "" &&
                array_key_exists('arrival', $_POST) && $_POST['arrival'] !== "" &&
                array_key_exists('firstclass', $_POST) && $_POST['firstclass'] !== "" &&
                array_key_exists('business', $_POST) && $_POST['business'] !== "" &&
                array_key_exists('economy', $_POST) && $_POST['economy'] !== "") {
                // add route and redirect if successful
                // else render page with error message
                $departure = $_POST['departure'];
                $arrival = $_POST['arrival'];
                $firstclass = $_POST['firstclass'];
                $business = $_POST['business'];
                $economy = $_POST['economy'];
                $success = $this->database->addRoute($departure, $arrival, (int)$firstclass, (int)$business, (int)$economy);
                if ($success) {
                    header('Location: /routes');    
                } else {
                    $this->context['error'] = "Failed to add route. Please check that airports exist.";
                    $this->renderError();
                }
            } else {
                // render error
                $this->context['error'] = "Please fill in all the fields!";
                $this->renderError();
            }
        } else {
            // If not staff render 403 forbidden page
            $this->renderForbidden();
        } 
    }
}
