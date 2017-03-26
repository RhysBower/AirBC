<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class LoyaltyMember extends Customer
{
    public $points;

    public function __construct(int $id, string $name, string $email, string $username, string $password,
                                string $travelDocument, string $billingAddress, string $phoneNumber,
                                string $seatPreference, string $paymentInformation,
                                int $points)
    {
        parent::__construct($id, $name, $email, $username, $password, $travelDocument, $billingAddress,
                            $phoneNumber, $seatPreference, $paymentInformation, $points);
        $this->points = $points;
    }
}
