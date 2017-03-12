<?php declare(strict_types=1);
namespace Airbc;

/**
 * Controls access to database.
 * Other classes can make requests for data through here.
 */
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

    /**
     * Returns Account with given id or null if no Account exists.
     */
    public function getAccount(int $id): Model\Account
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
            $this->logSqlError();
            return null;
        }
    }

    /**
     * Returns array of Account or empty array if no Accounts are found.
     */
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
            $this->logSqlError();
            return [];
        }
    }

    /**
     * Returns Account with given id or null if no Account exists.
     */
    public function getRoute(string $departure, string $arrival): Model\Route
    {
        if ($result = $this->mysqli->query("SELECT * FROM Route WHERE departure=$departure AND arrival=$arrival")) {
            $this->logger->info("SELECT Route returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return null;
            }
            if ($result->num_rows > 1) {
                throw new \Exception("Duplicate routes detected.");
            }

            $row = $result->fetch_object();
            $routes = new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);;

            $result->close();

            return $routes;
        } else {
            $this->logSqlError();
            return null;
        }
    }


    /**
     * Returns array of Routes or empty array if no Routes are found.
     */
    public function getRoutes(): array
    {
        if ($result = $this->mysqli->query("SELECT * FROM Route")) {
            $this->logger->info("SELECT Routes returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return [];
            }
            $routes = [];
            while ($row = $result->fetch_object()){
                $routes[] = new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);
            }
            $result->close();
            return $routes;
        } else {
            $this->logSqlError();
            return [];
        }
    }

    /**
     * Returns array of Flights or empty array if no Flights are found.
     */
    public function getFlights(): array
    {
        if ($result = $this->mysqli->query("SELECT * FROM Flight")) {
            $this->logger->info("SELECT Flights returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return [];
            }

            $flights = [];
            while ($row = $result->fetch_object()){

                /*$time = strtotime($row->datetime);
                $myFormatForView = date("m/d/y g:i A", $time);*/
                $date = new \DateTime($row->date_time);
                $res = $date->format('h:i A, F d, Y');
                $flights[] = new Model\Flight((int)$row->id, (string)$res, (string)$row->assigned, (string)$row->arrival, (string)$row->departure);
            }
            $result->close();

            return $flights;
        } else {
            $this->logSqlError();
            return [];
        }
    }

    public function __destruct()
    {
        $this->logger->info('Closing MySQL connection');
        $this->mysqli->close();
    }

    private function logSqlError() {
        $this->logger->alert("Query failed with errno: ".$this->mysqli->errno."\n".$this->mysqli->error);
    }
}
