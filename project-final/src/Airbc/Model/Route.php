<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Route extends Object {
    private Airport $departure;
    private Airport $arrival;
    private int $firstClass;
    private int $business;
    private int $economy;
}
