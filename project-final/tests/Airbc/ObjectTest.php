<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Airbc\Object;

final class ObjectTest extends TestCase
{
    public function testCannotWriteInaccessibleProperty(): void
    {
        $this->expectException(DomainException::class);

        $object = new Object();
        $object->invalid = "property";
    }

    public function testCannotReadInaccessibleProperty(): void
    {
        $this->expectException(DomainException::class);

        $object = new Object();
        $invalid = $object->invalid;
    }
}
