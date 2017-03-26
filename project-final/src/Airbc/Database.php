<?php declare(strict_types=1);
namespace Airbc;

use Airbc\Log;
use Airbc\MySQL\MySQL;
use Airbc\MySQL\MySQLException;

/**
 * Controls access to database.
 * Other classes can make requests for data through here.
 */
class Database extends Object
{
    private static $mysql;

    public function __construct()
    {
        try {
            self::$mysql = new MySQL('localhost', 'root', 'root', 'cpsc304');
            self::$mysql->connect();
        } catch (MySQLException $e) {
            Log::emergency('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
            die('Connect Error (' . $e->getCode() . ') ' . $e->getMessage());
        }

        Log::info('Connected to MySQL: ' . self::$mysql->hostInfo());
    }

    /**
     * Returns Account with given id or null if no Account exists.
     */
    public static function getAccount(int $id): ?Model\Account
    {
        return self::querySingle("SELECT * FROM Account WHERE id=$id", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    /**
     * Returns Account with given username or null if no Account exists.
     */
    public static function getUserAccount(string $username): ?Model\Account
    {
        return self::querySingle("SELECT * FROM Account WHERE username='$username'", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    public static function getCustomer(int $id): ?Model\Customer
    {
        return self::querySingle("SELECT * FROM Account, Customer WHERE Account.id=Customer.id AND Account.id=$id", function($row) {
            return new Model\Customer((int)$row->id, $row->name, $row->email, $row->username, $row->password,
                                        $row->travel_document, $row->billing_address, $row->phone_number,
                                        $row->seat_preference, $row->payment_information);
        });
    }

    public static function getLoyaltyMember(int $id): ?Model\LoyaltyMember
    {
        return self::querySingle("SELECT * FROM Account, Customer, Loyalty_Member WHERE Account.id=Customer.id AND
                                    Account.id=Loyalty_Member.id AND Account.id=$id", function($row) {
            return new Model\LoyaltyMember((int)$row->id, $row->name, $row->email, $row->username, $row->password,
                                        $row->travel_document, $row->billing_address, $row->phone_number,
                                        $row->seat_preference, $row->payment_information,
                                        (int) $row->points);
        });
    }

    public static function getStaff(int $id): ?Model\Staff
    {
        return self::querySingle("SELECT * FROM Account, Staff WHERE Account.id=Staff.id AND Account.id=$id", function($row) {
            return new Model\Staff((int)$row->id, $row->name, $row->email, $row->username, $row->password,
                                        $row->title);
        });
    }

    /**
     * Returns array of Account or empty array if no Accounts are found.
     */
    public static function getAccounts(): array
    {
        return self::queryMultiple("SELECT * FROM Account", function($row) {
            return new Model\Account((int)$row->id, $row->name, $row->email, $row->username, $row->password);
        });
    }

    /**
     * Returns true if account with given id is a customer, false otherwise.
     */
    public static function isCustomer(int $id): bool
    {
        return self::isAccount("SELECT * FROM Customer WHERE id=$id");
    }

    /**
     * Returns true if account with given id is a loyalty member, false otherwise.
     */
    public static function isLoyaltyMember(int $id): bool
    {
        return self::isAccount("SELECT * FROM Loyalty_Member WHERE id=$id");
    }

    /**
     * Returns true if account with given id is a staff, false otherwise.
     */
    public static function isStaff(int $id): bool
    {
        return self::isAccount("SELECT * FROM Staff WHERE id=$id");
    }

    /**
     * Returns a Route from departure airport to arrival airport.
     */
    public static function getRoute(string $departure, string $arrival): ?Model\Route
    {
        return self::querySingle("SELECT * FROM Route WHERE departure='$departure' AND arrival='$arrival'", function($row) {
            return new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);
        });
    }


    /**
     * Returns array of Routes or empty array if no Routes are found.
     */
    public static function getRoutes(): array
    {
        return self::queryMultiple("SELECT * FROM Route", function($row) {
            return new Model\Route((string)$row->departure, (string)$row->arrival, (int)$row->first_class, (int)$row->business, (int)$row->economy);
        });
    }

    /**
     * Returns true if Route is added, false otherwise.
     */
    public static function addRoute(string $departure, string $arrival, string $firstclass, string $business, string $economy): bool
    {
        return self::queryModify("INSERT INTO Route (departure, arrival, first_class, business, economy) VALUES
            ('$departure', '$arrival', $firstclass, $business, $economy)");
    }

    /**
     * Returns array of Flights or empty array if no Flights are found.
     */
    public static function getFlights(): array
    {
        return self::queryMultiple("SELECT * FROM Flight", function($row) {
            $date = new \DateTime($row->date_time);
            $res = $date->format('h:i A, F d, Y');
            return new Model\Flight((int)$row->id, (string)$res, (string)$row->assigned, (string)$row->arrival, (string)$row->departure);
        });
    }

    /**
     * Returns a Flight with id or null if not found.
     */
    public static function getFlight(int $id): ?Model\Flight
    {
        return self::querySingle("SELECT * FROM Flight WHERE id=$id", function($row) {
            $date = new \DateTime($row->date_time);
            $res = $date->format('h:i A, F d, Y');
            return new Model\Flight((int)$row->id, (string)$res, (string)$row->assigned, (string)$row->arrival, (string)$row->departure);
        });
    }

    /**
     * Returns array of Flights on Route or empty array if no Flights are found.
     */
    public function getFlightsOnRoute(string $departure, string $arrival): array
    {
        return $this->queryMultiple("SELECT * FROM Flight WHERE arrival='$arrival' AND departure='$departure'", function($row) {
            $date = new \DateTime($row->date_time);
            $res = $date->format('h:i A, F d, Y');
            return new Model\Flight((int)$row->id, (string)$res, (string)$row->assigned, (string)$row->arrival, (string)$row->departure);
        });
    }

    /**
     * Returns true if Flight is added, false otherwise.
     */
    public static function addFlight(string $date_time, string $assigned, string $arrival, string $departure): bool
    {
        return self::queryModify("INSERT INTO Flight (date_time, assigned, arrival, departure) VALUES
            ('$date_time', '$assigned', '$arrival', '$departure')");
    }

    /**
     * Returns array of Airports or empty array if no Airports are found.
     */
    public static function getAirports(): array
    {
        return self::queryMultiple("SELECT * FROM Airport", function($row) {
            return new Model\Airport((string)$row->id, (string)$row->name, (string)$row->location);
        });
    }
    // General search of airports
    public static function getAirportsSearch(string $query): array // why can't I overload methods :(
    {
        return self::queryMultiple("SELECT * FROM Airport
            WHERE (`id` LIKE '%".$query."%') OR (`name` LIKE '%".$query."%') OR (`location` LIKE '%".$query."%')",
            function($row){
                return new Model\Airport((string)$row->id, (string)$row->name, (string)$row->location);
            });
    }

    /**
     * Returns an Airport with given id or null if no Airport is found.
     */
    public static function getAirport(string $id): ?Model\Airport
    {
        return self::querySingle("SELECT * FROM Airport WHERE id='$id'", function($row) {
            return new Model\Airport((string)$row->id, (string)$row->name, (string)$row->location);
        });
    }

    // Inserts an airport, and returns list view back TODO: return false if cannot insert ???
    public static function addAirport(string $id, string $name, string $location): array
    {
        Log::emergency('adding...');
        return self::queryMultiple("INSERT INTO Airport (id, name, location) VALUES
            ('$id','$name','$location')", function($row) {
            return new Model\Airport((string)$row->id, (string)$row->name, (string)$row->location);
        });
    }
    // Removes an airport, and returns list view back
    public static function removeAirport(string $id): void
    {
        self::querySingle("DELETE FROM Airport WHERE id='$id'", function($row){} );
    }

    /**
     * Returns array of Tickets or empty array if no Tickets are found.
     */
    public static function getTickets(): array
    {
        return self::queryMultiple("SELECT * FROM Ticket", function($row) {
            return new Model\Ticket((string)$row->id, (string)$row->seat_type, (string)$row->flightId,
                (string)$row->customerId, (string)$row->purchasedBy);
        });
    }

    /**
     * Returns a Ticket with id or null if not found.
     */
    public static function getTicket(int $id): ?Model\Ticket
    {
        return self::querySingle("SELECT * FROM Ticket WHERE id=$id", function($row) {
            return new Model\Ticket((string)$row->id, (string)$row->seat_type, (string)$row->flightId,
                (string)$row->customerId, (string)$row->purchasedBy);
        });
    }

    /**
     * Adds a ticket
     */
    public static function addTicket(string $flightId, string $seatType, string $customerId,                             string $accountId): bool
    {
        return self::queryModify("INSERT INTO Ticket (seat_type, flightId, customerId, purchasedBy) VALUES ('$seatType', '$flightId', '$customerId', '$accountId')");
    }

    /**
     * Removes a ticket, returns the list of tickets view
     */
    public static function removeTicket(string $id): void
    {
        self::querySingle("DELETE FROM Ticket WHERE id='$id'", function($row){} );
    }

    /**
     * Return true if aircraft is in operation, false otherwise.
     */
    public static function isOperational(string $id): bool
    {
        try {
            $result = self::isAccount("SELECT * FROM Aircraft WHERE id='$id' AND status='OK'");
            return $result;
        } catch (MySQLException $e) {
            self::logSqlError($e);
            return false;
        }
    }

    private static function isAccount(string $query): bool {
        try {
            $result = self::$mysql->query($query);
            Log::info("$query returned $result->num_rows rows");
            if ($result->num_rows == 0) {
                return false;
            }
            if ($result->num_rows > 1) {
                throw new \Exception("Duplicate account detected.");
            }
            $result->close();
            return true;
        } catch (MySQLException $e) {
            self::logSqlError($e);
            return false;
        }
    }

    public function __destruct()
    {
        Log::info('Closing MySQL connection');
        self::$mysql->close();
    }

    private static function logSqlError(MySQLException $e) {
        Log::alert("Query failed with errno: ".$e->getCode()."\n".$e->getMessage());
    }

    private static function querySingle(string $query, callable $fn) {
        try {
            $result = self::$mysql->query($query);
            Log::info("$query returned $result->num_rows rows");
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
            self::logSqlError($e);
            return null;
        }
    }

    private static function queryMultiple(string $query, callable $fn) {
        try {
            $result = self::$mysql->query($query);
            Log::info("$query $result->num_rows rows");
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
            self::logSqlError($e);
            return [];
        }
    }

    private static function queryModify(string $query): bool {
        try {
            $result = self::$mysql->queryUpdate($query);
            Log::info($result);
            return $result;
        } catch (MySQLException $e) {
            self::logSqlError($e);
            return false;
        }
    }
}
