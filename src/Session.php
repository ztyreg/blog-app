<?php

class Session
{
    private $signed_in = false;
    private $token = "";
    public $user_id;

    function __construct()
    {
        session_start();
        $this->check_login();
    }

    public function is_signed_in()
    {
        return $this->signed_in;
    }

    public function login(int $user_id)
    {
        if ($user_id) {
            $this->user_id = $_SESSION['user_id'] = $user_id;
            $this->signed_in = true;
        }
        // generate token
        $this->token = $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function check_login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    /**
     * CSRF token
     * @param string $token
     * @return bool
     */
    public function verifyToken(string $token)
    {
        if (!hash_equals($token, $this->token)) {
            die("Request forgery detected");
        }
        return true;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

}

$session = new Session();