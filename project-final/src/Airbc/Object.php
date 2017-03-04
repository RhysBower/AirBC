<?php declare(strict_types=1);
namespace Airbc;

/**
 * Base object all classes should extend from.
 * Prevents reading and writing to undefined class properties.
 */
class Object
{
    public function __set(string $name, $value): void
    {
        throw new \DomainException("Attempted to write data to inaccessible property: $name");
    }

    public function __get(string $name): mixed
    {
        throw new \DomainException("Attempted to read data from inaccessible property: $name");
    }
}
