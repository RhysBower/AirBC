<?php declare(strict_types=1);
namespace Airbc\Router;

use Airbc\Object;
use Exception;

class Router extends Object
{
    public function get(string $url, callable $controller)
    {

    }

    public function post(string $url, callable $controller)
    {

    }

    public function put(string $url, callable $controller)
    {

    }

    public function patch(string $url, callable $controller)
    {

    }

    public function delete(string $url, callable $controller)
    {

    }

    public static function urlToRouter(string $url, string $route): Route
    {
        $urlExplode = explode('/', $url);
        $routeExplode = explode('/', $route);

        if(count($urlExplode) !== count($routeExplode)) {
            throw new Exception("url and route length don't match");
        }

        $params = [];

        for($i = 0; $i < count($routeExplode); $i++) {
            if ((mb_substr($routeExplode[$i], 0, 1) === '{') &&
                (mb_substr($routeExplode[$i], mb_strlen($routeExplode[$i])-1) === '}')) {
                $params[mb_substr($routeExplode[$i], 1, mb_strlen($routeExplode[$i])-2)] = $urlExplode[$i];
            } else if ($routeExplode[$i] !== $urlExplode[$i]) {
                throw new Exception("url part doesn't match");
            }
         }

        return new Route($url, $params);
    }
}
