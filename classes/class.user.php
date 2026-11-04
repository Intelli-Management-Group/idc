<?php

require_once __DIR__ . '/class.password.php';

class User extends Password
{
    private $_db;

    public function __construct($db)
    {
        parent::__construct();

        $this->_db = $db;
    }

    public function is_logged_in()
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true;
    }

    private function get_user_hash($username)
    {
        try {
            $stmt = $this->_db->prepare('SELECT memberID, username, password, fullname FROM blog_members WHERE username = :username');
            $stmt->execute(array(':username' => $username));

            return $stmt->fetch();
        } catch (PDOException $e) {
            echo '<p class="error">' . $e->getMessage() . '</p>';
            return false;
        }
    }

    public function login($username, $password)
    {
        $user = $this->get_user_hash($username);

        if (!$user) {
            return false; // unknown username
        }

        if ($this->password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['loggedin'] = true;
            $_SESSION['memberID'] = $user['memberID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['author']   = $user['fullname'];
            return true;
        }

        return false;
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
    }
}
