<?php

namespace Controllers;

use Controllers\IControllers as IControllers;
use model\User as User;
use model\Role as Role;
use model\Profile as Profile;
use controllers\HomeController as HomeController;
use controllers\SessionManager as SessionManager;
use Dao\UserDB as UserDB;
use Dao\ProfileDB as ProfileDB;

class UserController implements IControllers
{

    private UserDB $DaoUser;
    private ProfileDB $DaoProfile;
    private SessionManager $SessionManager;

    public function __construct()
    {
        $this->DaoUser = new UserDB();
        $this->DaoProfile = new ProfileDB();
        $this->SessionManager = SessionManager::getInstance();
    }

    public function index(string $successMje = null, string $errorMje = null)
    {

        if ($this->SessionManager->CheckSession()) {
            $homeController = new HomeController();
            $homeController->index();
        } else {
            include(PAGES . "/login.php");
        }
    }

    public function CheckSessionForView()
    {
        if (!$this->SessionManager->CheckSession()) {
            include_once(PAGES . "/login.php");
        }
    }


    public function LogIn($email, $pass)
    {
        $errorMje = null;
        try {
            if ($this->DaoUser->UserExist($email)) //comprueba que exista el usuario
            {
                $user = $this->DaoUser->GetByEmail($email);

                if ($user->GetPass() == $pass) //comprobamos la contraseña
                {
                    $this->SessionManager->SetLogIn($user);
                    header("Location: " . FRONT_ROOT);
                } else {
                    $errorMje = "Error: Contraseña incorrecta";
                }
            } else {
                $errorMje = "Error usuario incorrecto";
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
            if (!$this->SessionManager->UserExist($email)) {
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
        $this->SessionManager->unSetLogIn();
        header("Location: " . FRONT_ROOT);
    }
}
