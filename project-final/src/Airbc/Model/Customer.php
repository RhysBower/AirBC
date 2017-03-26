<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Customer extends Account
{
    public $travelDocument;
    public $billingAddress;
    public $phoneNumber;
    public $seatPreference;
    public $paymentInformation;

    public function __construct(int $id, string $name, string $email, string $username, string $password,
                                string $travelDocument, string $billingAddress, string $phoneNumber,
                                string $seatPreference, string $paymentInformation)
    {
        parent::__construct($id, $name, $email, $username, $password);
        $this->travelDocument = $travelDocument;
        $this->billingAddress = $billingAddress;
        $this->phoneNumber = $phoneNumber;
        $this->seatPreference = $seatPreference;
        $this->paymentInformation = $paymentInformation;
    }
}
