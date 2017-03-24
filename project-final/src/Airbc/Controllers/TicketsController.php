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
        $this->context['flights'] = $this->database->getFlights();
    	
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

    public function addTicket() 
    {
        $this->context['page'] = "tickets";
        if (array_key_exists('from', $_POST) && $_POST['from'] !== "" &&
            array_key_exists('to', $_POST) && $_POST['to'] !== "" &&
            array_key_exists('passengers', $_POST) && $_POST['passengers'] !== "" &&
            array_key_exists('seatType', $_POST) && $_POST['seatType'] !== "") {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $passengers = $_POST['passengers'];
            $seatType = $_POST['seatType'];
            $ticketId = (string) rand(0, 2000);

            $flights = $this->database->getFlights();
            for ($x = 0; $x < sizeof($flights); $x++) {
                if ($flights[$x]->departure === $from && $flights[$x]->arrival === $to) {
                    $flightId = (string) $flights[$x]->id;
                    $this->database->addTicket($ticketId, $flightId, $seatType);
                } else {
                    $this->context['error'] = "This is not a valid flight to book!";
                }
            }
            
            header('Location: /tickets');
        } else {
            // render error
            $this->context['error'] = "Please fill in all the fields!";

            $template = $this->twig->load('bookTicket.twig');
            echo $template->render($this->context);
        }
    }

}
