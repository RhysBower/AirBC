<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Tickets page.
 */
class TicketsController extends Controller
{
    public function tickets()
    {
        $this->context['page'] = "tickets";
        $this->context['tickets'] = $this->database->getTickets();

        $template = $this->twig->load('tickets.twig');
        echo $template->render($this->context);
    }

    public function bookTicket()
    {
    	$this->context['page'] = "bookTicket";
    	$this->context['airports'] = $this->database->getAirports();
    	
    	$template = $this->twig->load('bookTicket.twig');
        echo $template->render($this->context);
    }

    public function getTicket($id)
    {
        $this->context['page'] = "tickets";
        $resultTicket = [];       
        $ticket = $this->database->getTicket(intval($id));
        if (!is_null($ticket))
            $resultTicket[] = $ticket;
        
        $this->context['tickets'] = $resultTicket;

        $template = $this->twig->load('tickets.twig');
        echo $template->render($this->context);
    }

}
