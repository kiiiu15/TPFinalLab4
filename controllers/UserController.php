<?php

namespace Controllers;

use Controllers\IControllers as IControllers;
use model\User as User;
use model\Role as Role;
use model\Profile as Profile;
use controllers\HomeController as HomeController;
use Dao\UserDB as UserDB;
use Dao\ProfileDB as ProfileDB;

class UserController implements IControllers
{

    private UserDB $DaoUser;
    private ProfileDB $DaoProfile;
    private HomeController $homeController;

    public function __construct()
    {
        $this->DaoUser = new UserDB();
        $this->DaoProfile = new ProfileDB();
        $this->homeController = new HomeController();
    }

    public function index(string $successMje = null, string $errorMje = null)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if ($this->CheckSession()) {
            $this->homeController->index();
        } else {
            include(PAGES . "/login.php");
        }
    }

    public function IsAdmin()
    {
        $answer = false;
        if ($this->CheckSession()) {
            if ($this->GetUserLoged()->GetRole()->getRoleName() == 'admin') {
                $answer = true;
            }
        }
        return $answer;
    }

    /**
     * sirve para saber quien es el usuario "logueado"
     * ademas si en home no se detecta ningun usuario logeado 
     * ni el estado "on" deberia redireccionar al login
     */
    public function setLogIn($user)
    {
        $_SESSION["status"] = "on";
        $_SESSION["logged"] = $user;
    }

    public function unSetLogIn()
    {
        unset($_SESSION["status"]);
        unset($_SESSION["logged"]);
    }

    public function CheckSessionForView()
    {
        if (!$this->CheckSession()) {
            include_once(PAGES . "/login.php");
        }
    }

    public function CheckSession()
    {
        $user = $this->GetUserLoged();
        $isLoggedIn = false;
        if ($user) {
            if ($this->UserExist($user->GetEmail())) {
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

    public function GetUserLoged()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['status']) && isset($_SESSION['logged'])) {
            return $_SESSION['logged'];
        } else {
            return false;
        }
    }

    /**
     * comprueba si ya existe un usuario con ese email
     */
    public function UserExist($email)
    {
        try {
            if ($this->DaoUser->GetByEmail($email)) {
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $ex) {
            $this->index(null, 'Error of connection: Try again');
        }
    }

    public function LogIn($email, $pass)
    {
        $errorMje = null;
        try {
            if ($this->UserExist($email)) //comprueba que exista el usuario
            {
                $user = $this->DaoUser->GetByEmail($email);

                if ($user->GetPass() == $pass) //comprobamos la contraseña
                {
                    $this->SetLogIn($user);
                    header("Location: " . FRONT_ROOT);
                } else {
                    $errorMje = "Error: Contraseña incorrecta";
                }
            } else {
                $errorMje = "Error: usuario incorrecto";
            }
        } catch (\PDOException $ex) {
            $errorMje = "Error: trouble verifying user";
        }

        $this->index(null, $errorMje);
    }

    public function SignUp($email, $pass, $UserName, $LastName, $Dni, $TelephoneNumber)
    {
        $successMje = null;
        $errorMje = null;
        try {
            if (!$this->UserExist($email)) {
                //POR DEFECTO SIEMPRE SE VAN A CREAR USUARIOS COMO "CLIENT" Y SI SE DESEA QUE SEA ADMIN, OTRO ADMIN DEBERA OTORGARLE ESE PERMISO
                $role = new Role("client");
                $profile = new Profile(0, $UserName, $LastName, $Dni, $TelephoneNumber);
                $user = new User($email, $pass, $role, $profile);
                $profileId = $this->DaoProfile->Add($profile);

                if ($profileId) {
                    if ($this->DaoUser->Add($user, $profileId)) {
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
        } catch (\PDOException $ex) {
            $errorMje = 'Error signing up';
        }

        $this->index($successMje, $errorMje);
    }

    public function LogOut()
    {
        $this->unSetLogIn();
        header("Location: " . FRONT_ROOT);
    }
}
