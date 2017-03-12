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
        $this->context['page'] = "home";
        $this->context['accounts'] = $this->database->getAccounts();

        $template = $this->twig->load('home.twig');
        echo $template->render($this->context);
    }
}
