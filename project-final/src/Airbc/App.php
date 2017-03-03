<?php declare(strict_types=1);
namespace Airbc;

class App extends Object
{
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $logger->info('App Init');
    }
}
