<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Airports page.
 */
class AirportsController extends Controller
{
    public function airports()
    {
    	$query = $_GET['query_airports'];

        $this->context['page'] = "airports";
        if($query){
        	$this->context['airports'] = $this->database->getAirportsSearch($query);
        } else{
        	$this->context['airports'] = $this->database->getAirports();
        }

        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }

    public function renderAddAirportPage()
    {
        $this->context['page'] = "airports"; // ??? works without
        $this->context['airports'] = $this->database->getAirports();

        $template = $this->twig->load('airports_add.twig');
        echo $template->render($this->context);
    }

    public function addAirport($id, $name, $location)
    {
        $this->database->addAirport($id, $name, $location);

        $this->context['page'] = "airports";
        $this->context['airports'] = $this->database->getAirports();

        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }
}
