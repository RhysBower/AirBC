<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Flights page.
 */
class FlightsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->context['page'] = "flights";
        $this->context['flights'] = $this->database->getFlights();

        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }
}
