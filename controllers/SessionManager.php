<?php

namespace Controllers;

use Dao\UserDB;

class SessionManager
{

    private static $instance = null;
    private UserDB $DaoUser;


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SessionManager();
        }

        return self::$instance;
    }

    private  function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $this->DaoUser = new UserDB();
    }


    public function UserExist($email)
    {
        try {
            if ($this->DaoUser->GetByEmail($email)) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            return false;
        }
    }


    public function CheckSession()
    {
        $user = $this->GetUserLoged();
        $isLoggedIn = false;
        if ($user) {
            if ($this->DaoUser->UserExist($user->GetEmail())) {
                try {
                    $userAux = $this->DaoUser->GetByEmail($user->GetEmail());
                    if ($userAux->GetPass() == $user->GetPass()) {
                        $isLoggedIn = true;
                    }
                } catch (\Throwable $th) {
                    return false;
                }
            }
        }

        return $isLoggedIn;
    }


    public function IsAdmin()
    {
        $answer = false;
        if ($this->CheckSession()) {
            if ($this->GetUserLoged()->GetRole()->getRoleName() == ADMIN_ROLE) {
                $answer = true;
            }
        }
        return $answer;
    }


    public function setValue($key, $value)
    {
        if (isset($key) && isset($value)) {
            $_SESSION[$key] = $value;
        }
    }


    public function getValue($key, $defaultValue = null)
    {

        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return $defaultValue;
        }
    }

    public function setLogIn($user)
    {
        $_SESSION["status"] = "on";
        $_SESSION["logged"] = $user;
    }

    public function GetUserLoged()
    {
        if (isset($_SESSION['status']) && isset($_SESSION['logged'])) {
            return $_SESSION['logged'];
        } else {
            return false;
        }
    }

    public function unSetLogIn()
    {
        unset($_SESSION["status"]);
        unset($_SESSION["logged"]);
    }
}
