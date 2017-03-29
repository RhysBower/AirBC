<?php declare(strict_types=1);
namespace Airbc\Controllers;

/**
 * Controller for the Aircrafts page.
 */
class AircraftsController extends Controller
{
    public function aircrafts()
    {
        $this->context['page'] = "aircrafts";
        $aircrafts = $this->database->getAircrafts();
        $this->context['aircrafts'] = $aircrafts;
        $template = $this->twig->load('aircrafts.twig');
        echo $template->render($this->context);
    }

    public function aircraftsSearch($input, $selected)
    {
    	$this->context['page'] = "aircrafts";
        $this->context['aircrafts'] = $this->database->getAircraftsSearch($input, $selected);
        $template = $this->twig->load('aircrafts.twig');
        echo $template->render($this->context);
    }
}
