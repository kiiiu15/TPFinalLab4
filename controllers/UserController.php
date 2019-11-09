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
    //private $userList;//esto era del json
    //private $userDao;//esto era del json
    
    public function __construct(){
       // $userDao = new UserDao();
       // $userList = $userDao->GetAll();
    }

    public function index(){    

        if(!isset($_SESSION))
        {
            session_start();
        }

        if(isset($_SESSION['status']) && isset($_SESSION['loged']))
        {
            $home = new HomeController();
            $home->index();
        }else{
            $home = new HomeController();
            $home->index();
            //include(VIEWS ."/login.php");
        }
    }

    public function IsAdmin(){
        $ans = /*$_SESSION['loged']->GetRole()->GetRoleName() == 'admin' ? true : false;*/ true;
        return $ans;
    }

    /**
     * sirve para saber quien es el usuario "logueado"
     * ademas si en home no se detecta ningun usuario logeado 
     * ni el estado "on" deberia redireccionar al login
     */
    public function setLogIn($user){
        
        $_SESSION["status"] = "on";
        $_SESSION["loged"] = $user;
        
    }

    public function GetUserLoged(){
        if(!isset($_SESSION)){
            session_start();
        }
        if( isset($_SESSION['status']) && isset($_SESSION['loged']) ){
            return $_SESSION['loged'];
        }else{
            return false;
        }
    }

    /**
     * comprueba si ya existe un usuario con ese email
     */
    public function UserExist($email){
        $DaoUser= new UserDB();
        try{
            if($DaoUser->GetByEmail($email)){
                return true;
            }else
            {
                return false;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function LogIn($email,$pass){

        $DaoUser= new UserDB();
        try{
            if($this->UserExist($email))//comprueba que exista el usuario
            {
                $user = $DaoUser->GetByEmail($email);
                if($user->GetPass() == $pass)//comprobamos la contraseña
                {
                    $this->SetLogIn($user);
                    $this->index();
                }else{
                    $errorMje = "Error: Contraseña incorrecta";
                    include(VIEWS."/login.php"); 
                }
            }else{
                $errorMje = "Error: usuario incorrecto";
                include(VIEWS."/login.php"); 
            }
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function SignUp($email,$pass,$UserName,$LastName,$Dni,$TelephoneNumber){

        try{
            if(!$this->UserExist($email))
            {
                //POR DEFECTO SIEMPRE SE VAN A CREAR USUARIOS COMO "CLIENT" Y SI SE DESEA QUE SEA ADMIN, OTRO ADMIN DEBERA OTORGARLE ESE PERMISO
                $role = new Role("client");
                $profile = new Profile($UserName,$LastName,$Dni,$TelephoneNumber);
                $user = new User($email,$pass,$role,$profile);

                $DaoUser= new UserDB();
                $DaoProfile = new ProfileDB();
                $profileId = $DaoProfile->Add($profile);

            
                if($profileId){
                    if($DaoUser->Add($user,$profileId)){
                        $successMje = "Usuario registrado correctamente";
                    }else{
                        $errorMje = "Error de usuario: intentelo de nuevo mas tarde...";
                    }
                }else{
                    $errorMje = "Error de Perfil: intentelo de nuevo mas tarde...";
                }
                
            }else{
                $errorMje = "Ya existe un usuario registrado con esa direccion de correo";

            }
        }catch(\PDOException $ex){
            throw $ex;
        }
        require(VIEWS. "/logIn.php");
    }

    public function LogOut(){
        //no estoy del todo seguro si esto esta bien
        session_destroy();
        include(VIEWS."/login.php"); 
    }
    
}


?>