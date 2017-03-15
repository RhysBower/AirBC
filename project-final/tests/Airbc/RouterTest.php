<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Airbc\Router\Router;
use Airbc\Router\Route;
use Airbc\Router\Request;
use Airbc\Router\HttpVerb;

final class RouterTest extends TestCase
{
    public function testSimpleUrl()
    {
        $route = new Route(HttpVerb::GET, '/', function (Request $request) {});
        $request = Router::urlToRouter($route, '/');
        $expected = new Request(HttpVerb::GET, '/', []);

        $this->assertEquals($expected, $request);
    }

    public function testParam()
    {
        $route = new Route(HttpVerb::GET, '/flights/{id}', function (Request $request) {});
        $request = Router::urlToRouter($route, '/flights/1024');
        $expected = new Request(HttpVerb::GET, '/flights/1024', ['id' => 1024]);

        $this->assertEquals($expected, $request);
    }

    public function testMultipleParams()
    {
        $route = new Route(HttpVerb::GET, '/flights/{id}/tickets/{tid}', function (Request $request) {});
        $request = Router::urlToRouter($route, '/flights/1024/tickets/1');
        $expected = new Request(HttpVerb::GET, '/flights/1024/tickets/1', ['id' => 1024, 'tid' => 1]);

        $this->assertEquals($expected, $request);
    }

    public function testInvalidUrl()
    {
        $route = new Route(HttpVerb::GET, '/flights', function (Request $request) {});
        $request = Router::urlToRouter($route, '/flights/1024');

        $this->assertNull($request);
    }
}
