<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Airports page.
 */
class AirportsController extends Controller
{
    public function airports()
    {
        $this->context['page'] = "airports";
    	$this->context['airports'] = $this->database->getAirports();
        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }

    public function getAirport($id) {
        $this->context['page'] = "airports";
        $airports = [];
        $airport = $this->database->getAirport($id);
        if ($airport !== null) $airports[] = $airport;
        $this->context['airports'] = $airports;
        $template = $this->twig->load('airports.twig');
        echo $template->render($this->context);
    }

    public function searchAirports($input)
    {
        $this->context['page'] = "airports";
        $this->context['airports'] = $this->database->getAirportsSearch($input);
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
                if(!$this->database->addAirport($id, $name, $location)){
                    $this->context['error'] = "Could not add Airport... (may be duplicate inputs)";
                }
                $this->context['airports'] = $this->database->getAirports();
                $template = $this->twig->load('airports.twig');
                echo $template->render($this->context);
                // header('Location: /airports');
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
        if($this->isStaff()) {
            $success = $this->database->removeAirport($id);
            if ($success) {
                header('Location: /airports');
            } else {
                $this->context['error'] = "Failed to remove airport.";
                $template = $this->twig->load('airports.twig');
                echo $template->render($this->context);
            }
        } else {
            $this->renderForbidden();
        }
    }
}
