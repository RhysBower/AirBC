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

    public function getAccount(int $id): ?Model\Account
    {
        if ($result = $this->mysqli->query("SELECT * FROM Account WHERE id=$id")) {
            $this->logger->info("SELECT Account returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return null;
            }
            if ($result->num_rows > 1) {
                throw new \Exception("Duplicate account detected.");
            }

            $row = $result->fetch_object();
            $account = new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);

            $result->close();

            return $account;
        } else {
            $this->logger->warn("SELECT Account query failed.");
            return null;
        }
    }

    public function getAccounts(): array
    {
        if ($result = $this->mysqli->query("SELECT * FROM Account")) {
            $this->logger->info("SELECT Accounts returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return [];
            }

            $accounts = [];
            while ($row = $result->fetch_object()){
                $accounts[] = new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
            }
            $result->close();

            return $accounts;
        } else {
            $this->logger->warn("SELECT Accounts query failed.");
            return [];
        }
    }

    public function __destruct()
    {
        $this->logger->info('Closing MySQL connection');
        $this->mysqli->close();
    }
}
