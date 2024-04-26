<?php

namespace Controllers;

use Controllers\IControllers as IControllers;
use model\User as User;
use model\Role as Role;
use model\Profile as Profile;
use Dao\UserDao as UserDao;
use controllers\HomeController as HomeController;
use controllers\MovieController as MovieController;
use \PDO as PDO;
use \Exception as Exception;
use Dao\UserDB as UserDB;
use Dao\ProfileDB as ProfileDB;

class UserController implements IControllers
{


    public function __construct()
    {
    }

    public function index($message = null)
    {

        if (!isset($_SESSION)) {
            session_start();
        }

        if ($this->CheckSession()) {
            $home = new HomeController();
            $home->index();
        } else {
            $errorMje = $message;
            include(PAGES . "/login.php");
        }
    }

    public function IsAdmin()
    {

        $ans = false;
        if ($this->CheckSession()) {
            if ($this->GetUserLoged()->GetRole()->getRoleName() == 'admin') {
                $ans = true;
            }
        }
        return $ans;
    }

    /**
     * sirve para saber quien es el usuario "logueado"
     * ademas si en home no se detecta ningun usuario logeado 
     * ni el estado "on" deberia redireccionar al login
     */
    public function setLogIn($user)
    {

        $_SESSION["status"] = "on";
        $_SESSION["loged"] = $user;
    }

    public function CheckSessionForView()
    {
        if (!$this->CheckSession()) {
            include_once(PAGES . "/login.php");
        }
    }

    public function CheckSession()
    {
        $db = new UserDB();
        $user = $this->GetUserLoged();
        $ans = false;
        if ($user) {
            if ($this->UserExist($user->GetEmail())) {
                try {
                    $userAux = $db->GetByEmail($user->GetEmail());
                    if ($userAux->GetPass() == $user->GetPass()) {
                        $ans = true;
                    }
                } catch (\Throwable $th) {
                    return false;
                }
            }
        }

        return $ans;
    }

    public function GetUserLoged()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['status']) && isset($_SESSION['loged'])) {
            return $_SESSION['loged'];
        } else {
            return false;
        }
    }

    /**
     * comprueba si ya existe un usuario con ese email
     */
    public function UserExist($email)
    {
        $DaoUser = new UserDB();
        try {
            if ($DaoUser->GetByEmail($email)) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            $this->index('Error of connection: Try again');
        }
    }

    public function LogIn($email, $pass)
    {


        $DaoUser = new UserDB();
        try {
            if ($this->UserExist($email)) //comprueba que exista el usuario
            {
                $user = $DaoUser->GetByEmail($email);

                if ($user->GetPass() == $pass) //comprobamos la contraseña
                {
                    $this->SetLogIn($user);
                    $this->index();
                } else {
                    $errorMje = "Error: Contraseña incorrecta";
                    include(PAGES . "/login.php");
                }
            } else {
                $errorMje = "Error: usuario incorrecto";
                include(PAGES . "/login.php");
            }
        } catch (\PDOExeption $ex) {
            $errorMje = "Error: trouble verifying user";
            include(PAGES . "/login.php");
        }
    }

    public function SignUp($email, $pass, $UserName, $LastName, $Dni, $TelephoneNumber)
    {

        try {
            if (!$this->UserExist($email)) {
                //POR DEFECTO SIEMPRE SE VAN A CREAR USUARIOS COMO "CLIENT" Y SI SE DESEA QUE SEA ADMIN, OTRO ADMIN DEBERA OTORGARLE ESE PERMISO
                $role = new Role("client");
                $profile = new Profile(0, $UserName, $LastName, $Dni, $TelephoneNumber);
                $user = new User($email, $pass, $role, $profile);

                $DaoUser = new UserDB();
                $DaoProfile = new ProfileDB();
                $profileId = $DaoProfile->Add($profile);


                if ($profileId) {
                    if ($DaoUser->Add($user, $profileId)) {
                        $successMje = "Usuario registrado correctamente";
                    } else {
                        $errorMje = "Error de usuario: intentelo de nuevo mas tarde...";
                    }
                } else {
                    $errorMje = "Error de Perfil: intentelo de nuevo mas tarde...";
                }
            } else {
                $errorMje = "Ya existe un usuario registrado con esa direccion de correo";
            }
            include(PAGES . "/login.php");
        } catch (\PDOException $ex) {
            $this->index('Error siging up');
        }
    }

    public function LogOut()
    {
        //no estoy del todo seguro si esto esta bien
        session_destroy();
        include(PAGES . "/login.php");
    }













    /*Methods for Facebook API*/

    public function loginWithFacebook($fbUserData)
    {
        $DaoUser = new UserDB();
        try {
            if ($this->UserExist($fbUserData['email'])) //comprueba que exista el usuario
            {
                $user = $DaoUser->GetByEmail($fbUserData['email']);

                if ($user) {
                    $this->SetLogIn($user);
                    $this->index();
                } else {
                    $errorMje = "Error: we Can´t access to your facebook acount";
                    include(PAGES . "/login.php");
                }
            } else {
                $errorMje = "Error: there are no records of such user in the database";
                include(PAGES . "/login.php");
            }
        } catch (\PDOExeption $ex) {
            $errorMje = "Error with Facebook login. Try Again";
            include(PAGES . "/login.php");
        }
    }
}
