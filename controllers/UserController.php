<?php
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\User as User;
use Dao\UserDao as UserDao;

class UserController implements IControllers
{
    private $userList;
    private $userDao;
    
    public function __construct(){
       // $userDao = new UserDao();
       // $userList = $userDao->GetAll();
    }

    public function index(){    
        
        include(VIEWS."/login.php");

    }

    public function setLogIn($user){
        
        $_SESSION["status"] = "on";
        $_SESSION["loged"] = $user;
        
    }

    public function userVerify($email,$pass){
        if($this->userExist($email))
        {
            if($this->userDao->getByEmail($email)->getPassword() == $pass)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function userExist($email){
        if ($this->userDao->getByEmail($email) != null){
            return true;
        }
    }

    public function logIn(){
        
        $this->userDao = new UserDao();
        $this->userList = $this->userDao->GetAll();

        $email = $_POST["email"];
        $pass = $_POST["password"];

        if($this->userVerify($email,$pass))
        {
            $user = new User($email,$pass);
            $this->setLogIn($user);
            include(VIEWS."/home.php"); 
        }else{
            $msg = "Error: usuario o contraseña incorrecto";
            include(VIEWS."/login.php"); 
        }
        
    }

    public function register($email,$pass){

        $this->userDao = new UserDao();
        $this->userList = $this->userDao->GetAll();

        if(!$this->userExist()){
            $user = new User($email,$pass);
            $userDao->Add($user);

            require(VIEWS. "/logIn.php");

        }else{
            $msg = "Error, ya existe un usuario con ese nombre";
            require(VIEWS. "/logIn.php");
        }
    }
    
}


?>