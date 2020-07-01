<?php

require_once("myconfig.php");

class Database
{
    public $connection;

    function __construct()
    {
        $this->open_db_connection();
    }

    /**
     * Open db
     */
    public function open_db_connection()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_errno) {
            die("Database connection failed badly" . $this->connection->connect_error);
        }

    }

    /**
     * Escape input
     * @param $string
     * @return mixed
     */
    public function escape_string($string)
    {
        return $this->connection->real_escape_string($string);
    }

}

$database = new Database();

