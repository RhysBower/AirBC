<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Airbc\MySQL\MySQL;
use Airbc\MySQL\MySQLException;

final class MySQLTest extends TestCase
{
    public function testInvalidPassword()
    {
        $this->expectException(MySQLException::class);

        $mysql = new MySQL('localhost', 'root', 'roots', 'cpsc304');
        $mysql->connect();
    }
}
