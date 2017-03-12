<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Tickets page.
 */
class TicketsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->context['page'] = "tickets";
        $this->context['tickets'] = $this->database->getTickets();

        $template = $this->twig->load('tickets.twig');
        echo $template->render($this->context);
    }
}
