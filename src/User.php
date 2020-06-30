<?php

class User
{
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;


    public static function find_all_users()
    {
        return self::find_query("SELECT * FROM users");
    }

    public static function find_user_by_id(int $user_id)
    {
        global $database;
        $the_result_array = self::find_query("SELECT * FROM users WHERE id=$user_id LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_query($sql)
    {
        global $database;
        $the_object_array = array();
        $result_set = $database->query($sql);
        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = self::instantiation($row);
        }
        return $the_object_array;
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
        if ($cnt == 1 && $password == $db_password) {
            // Login succeeded!
            return $db_user_id;
            // Redirect to your target page
        } else {
            // Login failed; redirect back to the login screen
            return false;
        }
//        if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
//            // Login succeeded!
//            $_SESSION['user_id'] = $user_id;
//            // Redirect to your target page
//        } else{
//            // Login failed; redirect back to the login screen
//        }
//        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function create_user($username, $password)
    {
        global $database;
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);
        // prepare statement
        $stmt = $database->connection->prepare("INSERT INTO users (username, password) values (?, ?)");
        $stmt->bind_param('ss', $username, $password);
        return $stmt->execute();
    }

    public static function instantiation($the_record)
    {
        $the_object = new self;
        foreach ($the_record as $the_attribute => $value) {
            if ($the_object->has_attribute($the_attribute)) {
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    private function has_attribute($the_attribute)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

}
