<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Account extends Object
{
    public $id;
    public $name;
    public $email;
    public $username;
    private $password;

    public function __construct(int $id, string $name, string $email, string $username, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
