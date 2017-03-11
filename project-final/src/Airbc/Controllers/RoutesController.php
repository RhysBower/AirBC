<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Routes page.
 */
class RoutesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $context = [];
        $context['page'] = "routes";
        $context['routes'] = $this->database->getRoutes();

        $template = $this->twig->load('routes.twig');
        echo $template->render($context);
    }
}
