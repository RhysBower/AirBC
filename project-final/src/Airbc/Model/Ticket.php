<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Ticket extends Object
{
    public $id;
    public $seat_type;
    public $flightId;
    public $customerId;

    public function __construct(string $id, string $seat_type, string $flightId, string $customerId)
    {
    	$this->id = $id;
    	$this->seat_type = $seat_type;
    	$this->flightId = $flightId;
    	$this->customerId = $customerId;
    }
}
