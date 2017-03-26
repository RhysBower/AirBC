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
}
