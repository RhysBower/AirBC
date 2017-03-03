<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Account extends Object {
    private int $id;
    private string $name;
    private string $email;
    private string $username;
    private string $password;
}
