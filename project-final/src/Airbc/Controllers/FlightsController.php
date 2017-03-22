<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Flights page.
 */
class FlightsController extends Controller
{
    public function flights()
    {
        $this->context['page'] = "flights";
        $flights = $this->database->getFlights();
        $flightAirports = [];
        foreach ($flights as $flight) {
            $departureArrival = $flight->getDepartureArrival();
            if (!is_null($departureArrival))
                $flightAirports[] = $departureArrival;
        }
        $this->context['flights'] = $flights;
        $this->context['flightAirports'] = $flightAirports;
        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function getFlight($id)
    {
        $this->context['page'] = "flights";
        $resultFlight = [];       
        $flight = $this->database->getFlight(intval($id));
        $flightAirports = [];
        if (!is_null($flight)) {
        	$resultFlight[] = $flight;
            $departureArrival = $flight->getDepartureArrival();
            if (!is_null($departureArrival))
                $flightAirports[] = $departureArrival;
        }
        $this->context['flights'] = $resultFlight;
        $this->context['flightAirports'] = $flightAirports;
        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function getFlightsOnRoute($departure, $arrival)
    {
    	$this->context['page'] = "flights";
        $flights = $this->database->getFlightsOnRoute($departure, $arrival);
    	$flightAirports = [];
        foreach ($flights as $flight) {
            $departureArrival = $flight->getDepartureArrival();
            if (!is_null($departureArrival))
                $flightAirports[] = $departureArrival;
        }
        $this->context['flights'] = $flights;
        $this->context['flightAirports'] = $flightAirports;
    	$template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }
}
