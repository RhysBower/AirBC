<?php
namespace Airbc;

class Object {

  public function  __set ( string $name , mixed $value ) {
    throw new \DomainException("Attempted to write data to inaccessible property: $name");
  }

  public function __get ( string $name ) {
    throw new \DomainException("Attempted to read data from inaccessible property: $name");
  }
}
