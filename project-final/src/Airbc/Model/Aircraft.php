<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Aircraft extends AircraftType {
    private string $id;
    private \DateTime $purchasedDate;
    private AircraftStatus $status;
}
