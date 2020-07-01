<?php

class User
{
    public $id;
    public $username;
    public $password;

    /**
     * User constructor.
     * @param $id
     * @param $username
     * @param $password
     */
    public function __construct($id, $username, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function find_username_from_id($id)
    {
        return htmlentities(User::select_user_by_id($id)[0]->getUsername());
    }

    public static function select_user_by_id($id)
    {
        global $database;
        $stmt = $database->connection->prepare("SELECT id, username, password FROM users WHERE id=?");
        $stmt->bind_param('i', $id);
        return self::execute_select($stmt);
    }

    private static function execute_select($stmt)
    {
        $stmt->execute();
        $id = $username = $password = "";
        $stmt->bind_result($id, $username, $password);
        $result_array = array();
        while ($stmt->fetch()) {
            $result_array[] = new User($id, $username, $password);
        }
        $stmt->close();
        return $result_array;
    }

    public static function verify_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        // prepare statement
        $stmt = $database->connection->prepare("SELECT COUNT(*), id, password FROM users WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $cnt = $db_user_id = $db_password = "";
        $stmt->bind_result($cnt, $db_user_id, $db_password);
        $stmt->fetch();
        $stmt->close();
        if ($cnt == 1 && password_verify($password, $db_password)) {
            // Login succeeded!
            return $db_user_id;
        } else {
            // Login failed; redirect back to the login screen
            return false;
        }
    }

    public static function create_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        // prepare statement
        $stmt = $database->connection->prepare("INSERT INTO users (username, password) values (?, ?)");
        $stmt->bind_param('ss', $username, $password);
        return $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


}
