<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Airports page.
 */
class AirportsController extends Controller
{
    public function airports()
    {
    	// $query = $_GET['query_airports'];

        $this->context['page'] = "airports";
        // if($query){
        	// $this->context['airports'] = $this->database->getAirportsSearch($query);
        // } else{
        	$this->context['airports'] = $this->database->getAirports();
        // }

        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }

    public function renderAddAirportPage()
    {
        if($this->isStaff()){
            $this->context['page'] = "airports";
            // $this->context['airports'] = $this->database->getAirports();
            $template = $this->twig->load('airports_add.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }

    public function addAirport()
    {
        // check if user is staff. 
        if($this->isStaff()) {
            $this->context['page'] = "airports";
            
            if (array_key_exists('id', $_POST) && $_POST['id'] !== "" &&
                array_key_exists('name', $_POST) && $_POST['name'] !== "" &&
                array_key_exists('location', $_POST) && $_POST['location'] !== "") {
                // add airport and redirect if successful
                // else render page with error message
                $id = $_POST['id'];
                $name = $_POST['name'];
                $location = $_POST['location'];
                $this->database->addAirport($id, $name, $location);
                header('Location: /airports');    
            } else {
                // render error
                $this->context['error'] = "Please fill in all the fields!";
                // $this->context['airports'] = $this->database->getAirports();
                $template = $this->twig->load('airports_add.twig');
                echo $template->render($this->context);
            }
        } else {
            // If not staff render 403 forbidden page
            $this->renderForbidden();
        }
        
    }

    public function removeAirport($id)
    {
        $this->database->removeAirport($id);
        header('Location: /airports');
    }
}
