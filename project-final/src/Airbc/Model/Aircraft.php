<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Aircraft extends Object
{
    public $id;
    public $type;
    public $purchasedDate;
    public $status;

    public function __construct(string $id, AircraftType $type, string $purchasedDate, string $status)
    {
        $this->id = $id;
        $this->type = $type;
        $this->purchasedDate = $purchasedDate;
        $this->status = $status;
    }
}
