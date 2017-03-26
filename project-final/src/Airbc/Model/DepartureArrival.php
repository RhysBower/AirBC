<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

/**
 * An object that has a departure airport and an arrival airport.
 */
class DepartureArrival extends Object
{
    public $departure;
    public $arrival;

    public function __construct(Airport $departure, Airport $arrival)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
    }
}
