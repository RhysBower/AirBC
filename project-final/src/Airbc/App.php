<?php
namespace Airbc;

class App extends Object {

  public function __construct(\Psr\Log\LoggerInterface $logger) {
    $logger->info('App Init');
  }
}
