<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use controllers\RoomController as RoomController;

use model\Buy as Buy;
use model\MovieFunction as MovieFunction;
use model\User as User;
use model\Cinema as Cinema;
use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;

class BuyController implements Icontrollers{
  
    /*public function DiscountDay($nameDay) {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $date = $days[date('N', strtotime($nameDay))];
        return $date;
    }*/

    public function ReciveBuy($idFunction,$numberOfTickets){
        $moviefunctionController = new MovieFunctionController();
        $function = $moviefunctionController->GetById($idFunction);  //obtengo la funcion
        
        
        $UserController = new UserController();
        $user = $UserController->GetUserLoged();  //obtengo el usuario

        $roomController = new RoomController();

        $buyDB = new BuyDB();
        
        $room = $function->getRoom(); //obtengo la sala

        if(!$user){
            include(VIEWS ."/login.php");
        }else{
        
            //validacion sobre la capacidad de la sala
            if($roomController->GetRemainingCapacity($idFunction,$numberOfTickets) > -1){
                $date =  date("l");
                
                $discount = 0;
                $total = 0;

                $discount = $room->getPrice() * 0.25;
                
                //validacion del dia martes y miercoles     
                if($date == "Tuesday" || $date == "Wednesday"){
                    $total = $room->getPrice() - $discount;
                }else{
                    $total = $total + $room->getPrice();
                }
            
                $buy = new Buy(0,$function,$date,$numberOfTickets,$total,$discount,$user,false);

                $buyDB->Add($buy);
            }else{
                //Hacer que este mensaje aparezca como alerta 
                $alertCapacity = "We are sorry, there is no capacity in the room. Try in another room ";
                include(VIEWS ."/posts.php");
            }
        }
        include(VIEWS ."/payment.php");
    }

    public function GetAll(){
        $listBuy= array();
        $buyDB= new BuyDB();
        try{
            $listBuy=$buyDB->GetAll();
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $listBuy;
    }

    public function Add($date = "", $numberOfTickets = 0, $total = 0, $discount = 0, $idUser = 0){
        $buyDB= new  BuyDB();
        $userDB= new UserDB();
        $user = $userDB->GetById($idUser);
        $buy = new Buy(0,$date,$numberOfTickets,$total,$discount,$user);
        try{
            $buyDB->Add($buy);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Delete($buy){
        $buyDb= new BuyDB();
        try{
            $buyDB->Delete($buy);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveById($idBuy){
        $buyDB = new BuyDB();
        $buy = new Buy();
        try{
            $buy=$buyDB->RetrieveById($idBuy);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $buy;
    }

    public function RetrieveByUser($user){
        $buyDB = new BuyDB();
        $buy = new Buy();
        try{
            $buy=$buyDB->RetrieveByUser($user);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $buy;
    }

    public function ChangeState($idBuy){
        $buyDB = new BuyDB();
        try{
            $buyDB->ChangeState($idBuy);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    

    public function index(){
        
    }


}

?>