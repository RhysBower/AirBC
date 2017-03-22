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
        $this->context['routes'] = $this->database->getRoutes();

        $template = $this->twig->load('routes.twig');
        echo $template->render($this->context);
    }

    public function getRoute($departure, $arrival)
    {
    	$this->context['page'] = "routes";
        $resultRoute = [];
        $route = $this->database->getRoute($departure, $arrival);
        if (!is_null($route))
            $resultRoute[] = $route;

        $this->context['routes'] = $resultRoute;

        $template = $this->twig->load('routes.twig');
        echo $template->render($this->context);
    }
}
