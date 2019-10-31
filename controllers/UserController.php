<?php
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\User as User;
use model\Role as Role;
use model\Profile as Profile;
use Dao\UserDao as UserDao;
use controllers\HomeController as HomeController;

use Dao\UserDB as UserDB;
use Dao\ProfileDB as ProfileDB;

class UserController implements IControllers
{
    private $userList;
    private $userDao;
    
    public function __construct(){
       // $userDao = new UserDao();
       // $userList = $userDao->GetAll();
    }

    public function prueba(){
        $DAO = new UserDB();
        $DAOPROFILE = new ProfileDB();
        $role = new Role("admin");
        
        // AGREGAR UN NUEVO USUARIO
        //$profile = new Profile('b','b','b','b'); 
        //$profileId = $DAOPROFILE->Add($profile);
        //$User = new User("b","b",$role,$profile);
        //RECORDATORIO IMPORTANTE, VERIFICAR QUE SI NO SE PUDO CREAR EL NUEVO USUARIO VAS A TENER UN
        //PERFIL HECHO SIN USUARIO ASIGNADO
        //$DAO->Add($User,$profileId);
        
        //var_dump(  $DAOPROFILE->GetProfileById(1)  );
       
        var_dump( $DAO->GetAll() );
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

    public function logIn($email,$pass){
        
        /*$this->userDao = new UserDao();
        $this->userList = $this->userDao->GetAll();

        if($this->userVerify($email,$pass))
        {
            $user = new User($email,$pass);
            $this->setLogIn($user);*/

            //esta linea de abajo hay que sacarla, y arreglar el login obviamente....
            $_SESSION["status"] = "on";


            $homeController = new HomeController();
            $homeController->index();
        /*}else{
            $errorMje = "Error: usuario o contraseña incorrecto";
            include(VIEWS."/login.php"); 
        }*/
        
    }

    public function register($email,$pass){

        $this->userDao = new UserDao();
        $this->userList = $this->userDao->GetAll();

        if(!$this->userExist($email)){
            $user = new User($email,$pass);
            $this->userDao->Add($user);
            $successMje = "Usuario registrado correctamente";
        }else{
            $errorMje = "Error: ya existe un usuario con ese nombre";
        }
        require(VIEWS. "/logIn.php");
    }

    public function logOut(){
        //no estoy del todo seguro si esto esta bien
        session_destroy();
        include(VIEWS."/login.php"); 
    }
    
}


?>