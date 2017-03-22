<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;
use Airbc\Database;

class Flight extends Object
{
    public $id;
    public $datetime;
    public $assigned;
    public $arrival;
    public $departure;

    public function __construct(int $id, string $datetime, string $assigned, string $arrival, string $departure)
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->assigned = $assigned;
        $this->arrival = $arrival;
        $this->departure = $departure;
    }

    /**
     * Returns a DepartureArrival object or null if any airport is not found.
     */
    public function getDepartureArrival(): ?DepartureArrival
    {
        $departureAirport = Database::getAirport($this->departure);
        $arrivalAirport = Database::getAirport($this->arrival);
        if (is_null($departureAirport) or is_null($arrivalAirport))
            return null;
        else
            return new DepartureArrival($departureAirport, $arrivalAirport);
    }
}
