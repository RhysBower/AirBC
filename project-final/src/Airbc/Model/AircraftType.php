<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class AircraftType extends Object {
    private string $type;
    private int $firstClassSeats;
    private int $businessSeats;
    private int $economySeats;
}
