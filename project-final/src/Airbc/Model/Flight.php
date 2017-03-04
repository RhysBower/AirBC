<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Flight extends Object
{
    private $id;
    private $datetime;
    private $assigned;
    private $route;
}
