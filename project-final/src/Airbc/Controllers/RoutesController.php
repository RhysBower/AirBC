<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Routes page.
 */
class RoutesController extends Controller
{
    public function routes()
    {
        $this->context['page'] = "routes";
        $routes = $this->database->getRoutes();
        $routeAirports = [];
        foreach ($routes as $route) {
            $departureArrival = $route->getDepartureArrival();
            if (!is_null($departureArrival))
                $routeAirports[] = $departureArrival;
        }
        $this->context['routes'] = $routes;
        $this->context['routeAirports'] = $routeAirports;
        $template = $this->twig->load('routes.twig');
        echo $template->render($this->context);
    }

    public function getRoute($departure, $arrival)
    {
    	$this->context['page'] = "routes";
        $resultRoute = [];
        $routeAirports = [];
        $route = $this->database->getRoute($departure, $arrival);
        if (!is_null($route)) {
            $departureArrival = $route->getDepartureArrival();
            if (!is_null($departureArrival)) {
                $resultRoute[] = $route;
                $routeAirports[] = $departureArrival;
            }
        }

        $this->context['routes'] = $resultRoute;
        $this->context['routeAirports'] = $routeAirports;

        $template = $this->twig->load('routes.twig');
        echo $template->render($this->context);
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
