<?php declare(strict_types=1);
namespace Airbc\Model;

use Airbc\Object as Object;

class Staff extends Account
{
    public $title;

    public function __construct(int $id, string $name, string $email, string $username, string $password,
                                string $title)
    {
        parent::__construct($id, $name, $email, $username, $password);
        $this->title = $title;
    }
}
