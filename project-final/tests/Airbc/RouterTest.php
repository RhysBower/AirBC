<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Airbc\Router\Router;
use Airbc\Router\Request;

final class RouterTest extends TestCase
{
    public function testSimpleUrl()
    {
        $route = Router::urlToRouter('/', '/');
        $expected = new Request('/', []);

        $this->assertEquals($expected, $route);
    }

    public function testParam()
    {
        $route = Router::urlToRouter('/flights/1024', '/flights/{id}');
        $expected = new Request('/flights/1024', ['id' => 1024]);

        $this->assertEquals($expected, $route);
    }

    public function testMultipleParams()
    {
        $route = Router::urlToRouter('/flights/1024/tickets/1', '/flights/{id}/tickets/{tid}');
        $expected = new Request('/flights/1024/tickets/1', ['id' => 1024, 'tid' => 1]);

        $this->assertEquals($expected, $route);
    }

    public function testInvalidUrl()
    {
        $this->expectException(Exception::class);

        $route = Router::urlToRouter('/flights/1024', '/flights');
    }
}
