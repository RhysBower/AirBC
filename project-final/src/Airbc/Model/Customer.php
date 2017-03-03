<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Account extends Account {
    private string $travelDocument;
    private string $billingAddress;
    private string $phoneNumber;
    private SeatType $seatPreference;
    private string $paymentInformation;
}
