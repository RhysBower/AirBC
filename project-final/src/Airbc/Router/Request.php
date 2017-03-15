<?php declare(strict_types=1);
namespace Airbc\Router;

use Airbc\Object;

class Request extends Object
{
    private $method;
    private $url;
    private $params;

    public function __construct(string $method, string $url, array $params)
    {
        $this->method = $method;
        $this->url = $url;
        $this->params = $params;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getParams() {
        return $this->params;
    }
}
