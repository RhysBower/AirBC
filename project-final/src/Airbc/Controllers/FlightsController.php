<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Flights page.
 */
class FlightsController extends Controller
{
    public function getFlights($flights, $search)
    {
        $this->context['page'] = "flights";
        $flightAirports = [];
        foreach ($flights as $flight) {
            $departureArrival = $flight->getDepartureArrival();
            if (!is_null($departureArrival))
                $flightAirports[] = $departureArrival;
        }
        $this->context['flights'] = $flights;
        $this->context['flightAirports'] = $flightAirports;
        $this->context['search'] = $search;
        $template = $this->twig->load('flights.twig');
        echo $template->render($this->context);
    }

    public function flights()
    {
        $flights = $this->database->getFlights();
        $this->getFlights($flights, null);
    }

    public function getFlight($id)
    {
        $flights = [];       
        $flight = $this->database->getFlight(intval($id));
        if (!is_null($flight)) $flights[] = $flight;
        $this->getFlights($flights, "Flight ID " . $id . ":");
    }

    public function getFlightsOnRoute($departure, $arrival)
    {
        $flights = $this->database->getFlightsOnRoute($departure, $arrival);
    	$this->getFlights($flights, "Flights from " . $departure . " to " . $arrival . ":");
    }

    public function getFlightsFrom($departure)
    {
        $flights = $this->database->getFlightsFrom($departure);
        $this->getFlights($flights, "Flights from " . $departure . ":");
    }

    public function getFlightsTo($arrival)
    {
        $flights = $this->database->getFlightsTo($arrival);
        $this->getFlights($flights, "Flights to " . $arrival . ":");
    }

    public function renderAddFlightPage()
    {
        if($this->isStaff()){
            $this->context['page'] = "flights";
            $template = $this->twig->load('flights_add.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }

    public function renderError(string $error) {
        $this->context['error'] = $error;
        $template = $this->twig->load('flights_add.twig');
        echo $template->render($this->context);
    }

    public function addFlight()
    {
        // check if user is staff. 
        if($this->isStaff()) {
            $this->context['page'] = "flights";
            
            if (array_key_exists('date_time', $_POST) && $_POST['date_time'] !== "" &&
                array_key_exists('assigned', $_POST) && $_POST['assigned'] !== "" &&
                array_key_exists('arrival', $_POST) && $_POST['arrival'] !== "" &&
                array_key_exists('departure', $_POST) && $_POST['departure'] !== "") {
                // add flight and redirect if successful
                // else render page with error message
                $date_time = $_POST['date_time'];
                $assigned = $_POST['assigned'];
                $arrival = $_POST['arrival'];
                $departure = $_POST['departure'];

                // assigned aircraft needs to be in operation
                if ($this->database->isOperational($assigned)) {

                    // check if date_time is of valid DateTime format
                    if (\DateTime::createFromFormat('Y-m-d G:i:s', $date_time) !== false) {
                        
                        // check if airports exist
                        if ($this->database->getAirport($arrival) !== null &&
                            $this->database->getAirport($departure) !== null) {

                            // check if route from arrival airport to departure airport exists
                            if ($this->database->getRoute($departure, $arrival) !== null) {
                                $success = $this->database->addFlight($date_time, $assigned, $arrival, $departure);
                                if ($success) {
                                    header('Location: /flights');    
                                } else {
                                    $error = "Failed to add Flight.";
                                    $this->renderError($error);
                                }
                            } else {
                                $error = "Failed to add Flight. Please check that the route from " . $arrival . " to " . $departure . " exists.";
                                $this->renderError($error);
                            }

                        } else {
                            $error = "Failed to add Flight. Please check that airports exist.";
                            $this->renderError($error);
                        }                      
                        
                    } else {
                        $error = "Failed to add Flight. Please enter a valid date and time in this format: YYYY-MM-DD HH:MM:SS. For example: 2017-02-13 17:00:00.";
                        $this->renderError($error);
                    }
                    
                } else {
                    $error = "Failed to add Flight. Please make sure the assigned aircraft is in operation.";
                    $this->renderError($error);
                }

            } else {
                // render error
                $error = "Please fill in all the fields!";
                $this->renderError($error);
            }

        } else {
            // If not staff render 403 forbidden page
            $this->renderForbidden();
        } 
    }
}
