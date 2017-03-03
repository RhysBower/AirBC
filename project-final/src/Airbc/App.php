<?php
namespace Airbc;

class App extends Object {

  public function __constructor(\Psr\Log\LoggerInterface $logger) {
    $logger->info('App Init');
  }
}
