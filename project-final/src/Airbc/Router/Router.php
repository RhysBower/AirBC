<?php declare(strict_types=1);
namespace Airbc\Router;

use Airbc\Object;
use Exception;

class Router extends Object
{
    private $routes;
    private $error404Controller;

    public function __construct() {
        $routes = [];
    }

    public function get(string $url, $controller, $callback)
    {
        $this->add(HttpVerb::GET, $url, $controller, $callback);
    }

    public function post(string $url, $controller, $callback)
    {
        $this->add(HttpVerb::POST, $url, $controller, $callback);
    }

    public function put(string $url, $controller, $callback)
    {
        $this->add(HttpVerb::PUT, $url, $controller, $callback);
    }

    public function patch(string $url, $controller, $callback)
    {
        $this->add(HttpVerb::PATCH, $url, $controller);
    }

    public function delete(string $url, $controller, $callback)
    {
        $this->add(HttpVerb::DELETE, $url, $controller, $callback);
    }

    public function add(string $method, string $url, $controller, $callback) {
        $route = new Route($method, $url, $controller, $callback);
        $this->routes[] = $route;
    }

    public function error404(callable $controller) {
        $this->error404Controller = $controller;
    }

    public function route($url) {
        foreach ($this->routes as $route) {
            $request = $this->validateUrl($url, $route);
            if($request !== null) {
                $c = $route->getController();
                $ctr = new $c();
                call_user_func_array([$ctr, $route->getCallback()], $request->getParams());
                return;
            }
        }
        // Route not found. Call render 404 page.
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], []);
        $controller = $this->error404Controller;
        $controller($request);
    }

    private function validateUrl(string $url, Route $route): ?Request {
        if($_SERVER['REQUEST_METHOD'] !== $route->getMethod()) {
            return null;
        }
        return Router::urlToRouter($route, $url);
    }

    public static function urlToRouter(Route $route, string $url): ?Request
    {
        $urlExplode = explode('/', $url);
        $routeExplode = explode('/', $route->getUrl());

        if(count($urlExplode) !== count($routeExplode)) {
            return null;
        }

        $params = [];

        for($i = 0; $i < count($routeExplode); $i++) {
            if ((mb_substr($routeExplode[$i], 0, 1) === '{') &&
                (mb_substr($routeExplode[$i], -1) === '}')) {
                $params[mb_substr($routeExplode[$i], 1, -1)] = $urlExplode[$i];
            } else if ($routeExplode[$i] !== $urlExplode[$i]) {
                return null;
            }
         }

        return new Request($route->getMethod(), $url, $params);
    }
}
