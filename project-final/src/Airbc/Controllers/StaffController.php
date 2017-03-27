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

    public function avgTickets() {
        if ($this->isStaff()) {
            $this->context['page'] = "staff";

            $avgTickets = Database::getAvgTickets();
            $this->context['avgTickets'] = $avgTickets;

            $template = $this->twig->load('avg_tickets.twig');
            echo $template->render($this->context);
        } else {
            $this->renderForbidden();
        }
    }
}
