<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Airports page.
 */
class AirportsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->context['page'] = "airports";
        $this->context['airports'] = $this->database->getAirports();

        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }
}
