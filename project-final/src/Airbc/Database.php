<?php declare(strict_types=1);
namespace Airbc;

class Database extends Object
{
    private $logger;
    private $mysqli;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;

        $this->mysqli = new \mysqli('localhost', 'root', 'root', 'cpsc304');

        if ($this->mysqli->connect_error) {
            $logger->emergency('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }

        $logger->info('Connected to MySQL: ' . $this->mysqli->host_info);
    }

    public function __destruct() {
        $this->logger->info('Closing MySQL connection');
        $this->mysqli->close();
    }
}
