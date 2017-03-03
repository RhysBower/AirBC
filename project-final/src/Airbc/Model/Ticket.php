<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Ticket extends Object {
    private int $id;
    private SeatType $seatType;
    private Flight $flight;
    private Customer $customer;
}
