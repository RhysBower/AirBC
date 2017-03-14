<?php declare(strict_types=1);
namespace Airbc\Router;

use Airbc\Object;

class Route extends Object
{
    private $url;
    private $params;

    public function __construct(string $url, array $params)
    {
        $this->url = $url;
        $this->params = $params;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getParams() {
        return $this->params;
    }
}
