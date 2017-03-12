<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the 404 error page.
 */
class Error404Controller extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->context['page'] = "404";

        http_response_code(404);
        $template = $this->twig->load('404.twig');
        echo $template->render($this->context);
    }
}
