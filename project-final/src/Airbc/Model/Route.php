<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

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
}
