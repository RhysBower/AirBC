<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;
use Airbc\Database;

class Route extends Object
{
    public $departure;
    public $arrival;
    public $firstClass;
    public $business;
    public $economy;

    public function __construct(string $departure, string $arrival, int $firstClass, int $business, int $economy)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->firstClass = $firstClass;
        $this->business = $business;
        $this->economy = $economy;
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
