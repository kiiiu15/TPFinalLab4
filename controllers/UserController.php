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
            //$home = new HomeController();
            //$home->index();
            include(VIEWS ."/login.php");
        }
    }

    public function IsAdmin(){
       // $ans = /*$_SESSION['loged']->GetRole()->GetRoleName() == 'admin' ? true : false;*/ true;
        $ans = false;
        if($this->CheckSession()){
            if($this->GetUserLoged()->GetRole()->getRoleName() == 'admin'){
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
    public function setLogIn($user){
        
        $_SESSION["status"] = "on";
        $_SESSION["loged"] = $user;
        
    }

    public function CheckSession(){
        $db = new UserDB();
        $user = $this->GetUserLoged();
        $ans = false;
        if($user){
            if($this->UserExist($user->GetEmail())){
                $userAux = $db->GetByEmail($user->GetEmail());
                if($userAux->GetPass() == $user->GetPass()){
                    $ans = true;
                }
            }
        }
        if(!$ans){
            include(VIEWS."/login.php");
        }
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
                $profile = new Profile(0,$UserName,$LastName,$Dni,$TelephoneNumber);
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
    












    /*Methods for Facebook API*/

    public function loginWithFacebook($fbUserData) {
        $DaoUser= new UserDB();
        try{
            if($this->UserExist($fbUserData['email']))//comprueba que exista el usuario
            {
                $user = $DaoUser->GetByEmail($fbUserData['email']);
                
                if($user)
                {
                    $this->SetLogIn($user);
                    $this->index();
                }else{
                    $errorMje = "Error: we Can´t access to your facebook acount";
                    include(VIEWS."/login.php"); 
                }
            }else{
                $errorMje = "Error: there are no records of such user in the database";
                include(VIEWS."/login.php"); 
            }
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        

        //var_dump($fbUserData);
/*
        if($this->UserExist($this->userDAO->retrieveAll(),$fbUserData["email"]))
        {
            $userLoggerFB=$this->userDAO->retrieveOneByEmail($fbUserData["email"]);
            if($userLoggerFB != null) 
            {
                $this->setSession($userLoggerFB);
                $message = "Welcome "  . $fbUserData["first_name"] . "!";
                $this->homeController->index($message, 3);
            }
        }
        else
        {
            $accountRegisterByFB["id"]=$fbUserData["id"];
            $accountRegisterByFB["email"]=$fbUserData["email"];
            $accountRegisterByFB["password"]=$fbUserData["password"];
            $accountRegisterByFB["confirm_password"]=$fbUserData["password"];
            $accountRegisterByFB["firstName"]=$fbUserData["first_name"];
            $accountRegisterByFB["lastName"]=$fbUserData["last_name"];
            $accountRegisterByFB["photo"]=$fbUserData["picture"];
            $this->createUserUsingFacebook($accountRegisterByFB);
        }*/
    }

 /*   private function verifyIfTheUserEmailBeUsing($accountsList, $userEmail) {
        $result=false;

        foreach($accountsList as $value)
        {
            if($value->getEmail()==$userEmail)
            {
                $result=true;
                break;
            }       
        }
        return $result;
    }

    private function createUserUsingFacebook($array) {
        $email = $array["email"];
        try
        {
            $idUserFacebook=$array["id"];
            $firstName = $array["firstName"];
            $lastName = $array["lastName"];
            $email = $array["email"];
            $photo = $array["photo"];

            //Password hash
            $options = [
                'cost' => 12,
            ];
            $unencryptedPassword = $array["password"];;
            $password = password_hash($unencryptedPassword, PASSWORD_BCRYPT, $options);
            //

            $userRoleDAO = new DAO_UserRole();
            $userRoleList = $userRoleDAO->retrieveAll();
            if(!empty($userRoleList)) {
                foreach($userRoleList as $userRole) {
                    if($userRole->getDescription() == "user") {
                        $userRole = $userRole;
                        break;
                    }
                }
                $user = new M_User();
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setUserRole($userRole);
                $user->setIdFacebook($idUserFacebook);
                

                $this->userDAO->create($user);
                $this->prepareFBprofileImg($idUserFacebook,$user->getEmail());

                $this->loginUser($email, $unencryptedPassword);
                //A login is made to, with the email and password, load the user from the database and bring the ID
            }
            else {
                $message = "There was a problem creating the user. Try again";
                $this->homeController->signup($message, 0);
            } 
    }
    catch(PDOException $e)
    {
        $message = "A database error ocurred";
        $this->homeController->signup($message, 0);
    }            
    }

    private function prepareFBprofileImg($idUserFacebook,$email)  {
        $userSearched=$this->userDAO->retrieveOneByEmail($email);
        $url="https://graph.facebook.com/".$idUserFacebook."/picture?type=large&redirect=true&width=600&height=600";
        $data = file_get_contents($url);
        
        $this->userDAO->updatePhoto($data,$userSearched->getId());
    }


*/



}


?>