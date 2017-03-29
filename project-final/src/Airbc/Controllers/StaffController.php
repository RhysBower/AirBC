<?php declare(strict_types=1);
namespace Airbc\Controllers;

use Airbc\Database;

/**
 * Controller for the Staff page.
 */
class StaffController extends Controller
{
    public function staff()
    {
        if ($this->isStaff()) {
            $this->context['page'] = "staff";

            $template = $this->twig->load('staff.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }

    public function ticketInfo(string $aggregation) {
        if ($this->isStaff()) {
            $this->context['page'] = "staff";

            $avgTickets = Database::getTicketsInfo($aggregation);
            $this->context['avgTickets'] = $avgTickets;
            $this->context['aggregation'] = ucfirst($aggregation);

            $template = $this->twig->load('avg_tickets.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }

    public function customersBookedAllFlights() {
        if ($this->isStaff()) {
            $this->context['page'] = "staff";

            $cIDs = Database::getBookedAllFlights();
            $cAccounts = array();
            foreach ($cIDs as $cId) {
                array_push($cAccounts, Database::getAccount((int) $cId->id));
            }
            $this->context['customers'] = $cAccounts;

            $template = $this->twig->load('all_tickets.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }
}
