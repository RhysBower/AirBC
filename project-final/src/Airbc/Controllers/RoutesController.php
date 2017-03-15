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
}
