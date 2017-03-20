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
        $this->context['flights'] = $this->database->getFlights();

        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function getFlight($id)
    {
        $this->context['page'] = "flights";
        $flight = [];       
        $flight[] = $this->database->getFlight(intval($id));
        $this->context['flights'] = $flight;

        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }
}
