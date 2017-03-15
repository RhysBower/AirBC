<?php declare(strict_types=1);
namespace Airbc\Router;

use Airbc\Object;

class HttpVerb extends Object {
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
}
