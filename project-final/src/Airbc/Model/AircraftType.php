<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class AircraftType extends Object
{
    public $type;
    public $firstClassSeats;
    public $businessSeats;
    public $economySeats;

    public function __construct(string $type, int $firstClassSeats, int $businessSeats, int $economySeats)
    {
        $this->type = $type;
        $this->firstClassSeats = $firstClassSeats;
        $this->businessSeats = $businessSeats;
        $this->economySeats = $economySeats;
    }
}
