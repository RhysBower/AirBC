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
}
