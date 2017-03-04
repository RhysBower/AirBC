<?php declare(strict_types=1);
namespace Airbc;

class App extends Object
{
    private $database;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $logger->info('App Init');
        $database = new Database($logger);
        $account = $database->getAccount(1);
    }
}
