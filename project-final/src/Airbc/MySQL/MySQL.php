<?php declare(strict_types=1);
namespace Airbc\MySQL;

use Airbc\Object;
use mysqli;

class MySQL extends Object
{
    private $mysqli;
    private $host;
    private $username;
    private $password;
    private $dbname;

    public function __construct(string $host, string $username, string $password, string $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->mysqli = mysqli_init();
        if (!$this->mysqli) {
            throw new MySQLException("mysqli_init failed");
        }
    }

    public function connect()
    {
        if (!@$this->mysqli->real_connect($this->host, $this->username, $this->password, $this->dbname)) {
            throw new MySQLException($this->mysqli->connect_error, $this->mysqli->connect_errno);
        }
    }

    public function query(string $query)
    {
        $queryResult = $this->mysqli->real_query($query);
        if (!$queryResult) {
            throw new MySQLException($this->mysqli->error, $this->mysqli->errno);
        }

        $result = $this->mysqli->store_result();
        if ($this->mysqli->errno !== 0) {
            throw new MySQLException($this->mysqli->error, $this->mysqli->errno);
        }
        return $result;
    }

    public function hostInfo():string
    {
        return $this->mysqli->host_info;
    }

    public function close():void
    {
        if (!$this->mysqli->close()) {
            throw new MySQLException($this->mysqli->error, $this->mysqli->errno);
        }
    }
}
