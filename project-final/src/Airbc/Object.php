<?php declare(strict_types = 1);
namespace Airbc;

class Object {

  public function  __set ( string $name , $value ): void {
    throw new \DomainException("Attempted to write data to inaccessible property: $name");
  }

  public function __get ( string $name ): mixed {
    throw new \DomainException("Attempted to read data from inaccessible property: $name");
  }
}
