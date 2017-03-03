<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Flight extends Object {
    private int $id;
    private \DateTime $datetime;
    private Aircraft $assigned;
    private Route $route;
}
