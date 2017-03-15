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

    public function get(string $url, callable $controller)
    {
        $this->add(HttpVerb::GET, $url, $controller);
    }

    public function post(string $url, callable $controller)
    {
        $this->add(HttpVerb::POST, $url, $controller);
    }

    public function put(string $url, callable $controller)
    {
        $this->add(HttpVerb::PUT, $url, $controller);
    }

    public function patch(string $url, callable $controller)
    {
        $this->add(HttpVerb::PATCH, $url, $controller);
    }

    public function delete(string $url, callable $controller)
    {
        $this->add(HttpVerb::DELETE, $url, $controller);
    }

    public function add(string $method, string $url, callable $controller) {
        $route = new Route($method, $url, $controller);
        $this->routes[] = $route;
    }

    public function error404(callable $controller) {
        $this->error404Controller = $controller;
    }

    public function route($url) {
        foreach ($this->routes as $route) {
            $request = $this->validateUrl($url, $route);
            if($request !== null) {
                $route->getController()($request);
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
