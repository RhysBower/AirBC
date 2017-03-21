<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Log;

/**
 * Controller for the Flights page.
 */
class FlightsController extends Controller
{
    public function flights()
    {
        $this->context['page'] = "flights";
        $this->context['flights'] = $this->database->getFlights();

        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function getFlight($id)
    {
        $this->context['page'] = "flights";
        $resultFlight = [];       
        $flight = $this->database->getFlight(intval($id));
        if (!is_null($flight))
        	$resultFlight[] = $flight;
        
        $this->context['flights'] = $resultFlight;

        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function getFlightsOnRoute($departure, $arrival)
    {
    	$this->context['page'] = "flights";
    	$this->context['flights'] = $this->database->getFlightsOnRoute($departure, $arrival);
        
    	$template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }
}
