<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Airport extends Object
{
    public $id;
    public $name;
    public $location;

    public function __construct(string $id, string $name, string $location)
    {
    	$this->id = $id;
    	$this->name = $name;
    	$this->location = $location;
    }
}
