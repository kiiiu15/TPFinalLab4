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

    public function UserExist($email){
        $Dao = new UserDB();
        
        if($Dao->GetByEmail($email)){
            return true;
        }else
        {
            return false;
        }
    }

    public function logIn($email,$pass){

        $Dao = new UserDB();
        if($this->UserExist($email))
        {
            $user = $Dao->GetByEmail($email);
            if($user->GetPass() == $pass)
            {
                $this->SetLogIn($user);
                include(VIEWS."/home.php");
            }else{
                $errorMje = "Error: Contraseña incorrecta";
                include(VIEWS."/login.php"); 
            }
        }else{
            $errorMje = "Error: usuario incorrecto";
            include(VIEWS."/login.php"); 
        }
    }

    public function SignUp($email,$pass,$UserName,$LastName,$Dni,$TelephoneNumber){

        if(!$this->UserExist($email))
        {
            $role = new Role("client");
            $profile = new Profile($UserName,$LastName,$Dni,$TelephoneNumber);
            $user = new User($email,$pass,$role,$profile);

            $Dao = new UserDB();
            $ProfileDao = new ProfileDB();
            $profileId = $ProfileDao->Add($profile);

           
            if($profileId){
                if($Dao->Add($user,$profileId)){
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
        require(VIEWS. "/logIn.php");
    }

    public function LogOut(){
        //no estoy del todo seguro si esto esta bien
        session_destroy();
        include(VIEWS."/login.php"); 
    }
    
}


?>