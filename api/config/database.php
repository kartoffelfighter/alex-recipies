<?php

// database abstraction layer
// connect to database (mysql)

class Database
{

    //credentials
    private $host = "localhost";
    private $db_name = "recipies";
    private $username = "root";
    private $password = "";

    public $con;

    public function getConnection()
    {
        $this->con = null; // reset connection
        try { // try to connect to mysql host using pdo
            $this->con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PODEXception $exception) { // catch if error is present
            echo "Database Connection error: " . $exception->getMessage(); // display error message
        }
        return $this->con; // return db connection
    }
}
