<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the home page.
 */
class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $context = [];
        $context['page'] = "home";
        $context['accounts'] = $this->database->getAccounts();
        $context['routes'] = $this->database->getRoutes();

        $template = $this->twig->load('home.twig');
        echo $template->render($context);
    }
}
