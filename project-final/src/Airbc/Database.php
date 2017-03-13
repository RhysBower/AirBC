<?php declare(strict_types=1);
namespace Airbc;

use Airbc\MySQL\MySQL;
use Airbc\MySQL\MySQLException;

/**
 * Controls access to database.
 * Other classes can make requests for data through here.
 */
class Database extends Object
{
    private $logger;
    private $mysql;

    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;

        try {
            $this->mysql = new MySQL('localhost', 'root', 'root', 'cpsc304');
            $this->mysql->connect();
        } catch (MySQLException $e) {
            $logger->emergency('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
            die('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
        }

        $logger->info('Connected to MySQL: ' . $this->mysql->hostInfo());
    }

    /**
     * Returns Account with given id or null if no Account exists.
     */
    public function getAccount(int $id): ?Model\Account
    {
        return $this->querySingle("SELECT * FROM Account WHERE id=$id", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    /**
     * Returns Account with given username or null if no Account exists.
     */
    public function getUserAccount(string $username): ?Model\Account
    {
        return $this->querySingle("SELECT * FROM Account WHERE username='$username'", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    /**
     * Returns array of Account or empty array if no Accounts are found.
     */
    public function getAccounts(): array
    {
        return $this->queryMultiple("SELECT * FROM Account", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    /**
     * Returns true if account with given id is a customer, false otherwise.
     */
    public function isCustomer(int $id): bool
    {
        return $this->isAccount("SELECT * FROM Customer WHERE id=$id");
    }

    /**
     * Returns true if account with given id is a loyalty member, false otherwise.
     */
    public function isLoyaltyMember(int $id): bool
    {
        return $this->isAccount("SELECT * FROM Loyalty_Member WHERE id=$id");
    }

    /**
     * Returns true if account with given id is a staff, false otherwise.
     */
    public function isStaff(int $id): bool
    {
        return $this->isAccount("SELECT * FROM Staff WHERE id=$id");
    }

    /**
     * Returns a Route from departure airport to arrival airport.
     */
    public function getRoute(string $departure, string $arrival): ?Model\Route
    {
        return $this->querySingle("SELECT * FROM Route WHERE departure='$departure' AND arrival='$arrival'", function($row) {
            return new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);
        });
    }


    /**
     * Returns array of Routes or empty array if no Routes are found.
     */
    public function getRoutes(): array
    {
        return $this->queryMultiple("SELECT * FROM Route", function($row) {
            return new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);
        });
    }

    /**
     * Returns array of Flights or empty array if no Flights are found.
     */
    public function getFlights(): array
    {
        return $this->queryMultiple("SELECT * FROM Flight", function($row) {
            $date = new \DateTime($row->date_time);
            $res = $date->format('h:i A, F d, Y');
            return new Model\Flight((int)$row->id, (string)$res, (string)$row->assigned, (string)$row->arrival, (string)$row->departure);
        });
    }

    // TODO: getFlight(...)

    /**
     * Returns array of Airports or empty array if no Airports are found.
     */
    public function getAirports(): array
    {
        return $this->queryMultiple("SELECT * FROM Airport", function($row) {
            return new Model\Airport((string)$row->id, (string)$row->name, (string)$row->location);
        });
    }

    /**
     * Returns array of Tickets or empty array if no Tickets are found.
     */
    public function getTickets(): array
    {
        return $this->queryMultiple("SELECT * FROM Ticket", function($row) {
            return new Model\Ticket((string)$row->id, (string)$row->seat_type, (string)$row->flightId,
                (string)$row->customerId);
        });
    }

    public function __destruct()
    {
        $this->logger->info('Closing MySQL connection');
        $this->mysql->close();
    }

    private function logSqlError(MySQLException $e) {
        $this->logger->alert("Query failed with errno: ".$e->getCode()."\n".$e->getMessage());
    }

    private function querySingle(string $query, callable $fn) {
        try {
            $result = $this->mysql->query($query);
            $this->logger->info("$query returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return null;
            }
            if ($result->num_rows > 1) {
                throw new \Exception("Duplicate rows detected.");
            }

            $row = $result->fetch_object();
            $model = $fn($row);
            $result->close();

            return $model;
        } catch (MySQLException $e) {
            $this->logSqlError($e);
            return null;
        }
    }

    private function queryMultiple(string $query, callable $fn) {
        try {
            $result = $this->mysql->query($query);
            $this->logger->info("$query $result->num_rows rows");
            if ($result->num_rows == 0) {
                return [];
            }

            $models = [];
            while ($row = $result->fetch_object()){
                $models[] = $fn($row);
            }
            $result->close();

            return $models;
        } catch (MySQLException $e) {
            $this->logSqlError($e);
            return [];
        }
    }

    private function isAccount(string $query): bool {
        try {
            $result = $this->mysql->query($query);
            $this->logger->info("$query returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return false;
            }
            if ($result->num_rows > 1) {
                throw new \Exception("Duplicate account detected.");
            }
            $result->close();
            return true;
        } catch (MySQLException $e) {
            $this->logSqlError($e);
            return false;
        }
    }
}
