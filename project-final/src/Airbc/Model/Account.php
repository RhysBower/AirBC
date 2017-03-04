<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Account extends Object
{
    private $id;
    private $name;
    private $email;
    private $username;
    private $password;

    public function __construct(int $id, string $name, string $email, string $username, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }
}
