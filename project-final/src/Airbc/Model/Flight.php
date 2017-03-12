<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

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
}
