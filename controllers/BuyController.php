<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use controllers\RoomController as RoomController;
use controllers\HomeController as HomeController;

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
        $user = /*$UserController->GetUserLoged()*/true;  //obtengo el usuario

        $roomController = new RoomController();

        $buyDB = new BuyDB(); //this directamente 
        
        $room = $function->getRoom(); //obtengo la sala

        if(!$user){
            include(VIEWS ."/login.php");
        }else{
        
            //validacion sobre la capacidad de la sala
            if($roomController->GetRemainingCapacity($idFunction,$numberOfTickets) > -1){
                $date =  date("l");
                $today = date("Y-m-d");
                $id = date("Ymdhms");
                $discount = 0;
                $total = 0;

               
                
                //validacion del dia martes y miercoles     
                if($date == "Tuesday" || $date == "Wednesday"){
                    $discount = $room->getPrice() * 0.25;
                    $total = $room->getPrice() - $discount;
                }else{
                    $total =  $room->getPrice();
                }
                //this add 
                $buy = new Buy($id,$function,$today,$numberOfTickets,$total,$discount,$user,false);
                $buyDB->Add($buy);
                include(VIEWS ."/payment.php");
            }else{
                //Hacer que este mensaje aparezca como alerta 
                $homeController = new HomeController();
                $alertCapacity = "We are sorry, there is no capacity in the room. Try in another room ";
                $homeController->index($alertCapacity);
                
            }
        }
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

    public function getTotalByDate($fromDate,$toDate,$cinema,$movie){
        $db = new BuyDB();
        $homeController = new HomeController();
        //si no especifica cine ni pelicula se muestra el total de todas las ventas
        if($cinema == "" && $movie == ""){
            
            try{
                $result = $db->getTotalByDate($fromDate,$toDate);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats($result,-1);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema != "" && $movie == ""){//solo se selecciono un cine pero no pelicula
            
            try{
                $result = $db->getTotalByCinema($fromDate,$toDate,$cinema);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats($result,-1);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema == "" && $movie != ""){
            
            try{
                $result = $db->getTotalByMovie($fromDate,$toDate,$movie);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats($result,-1);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema != "" && $movie != ""){
            try{
                $result = $db->getTotalByMovieAndCinema($fromDate,$toDate,$movie,$cinema);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats($result,-1);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }
        
    }

    public function getTotalTicketsSold($fromDate,$toDate,$cinema,$movie){
        $db = new BuyDB();
        $homeController = new HomeController();
        //si no especifica cine ni pelicula se muestra el total de todas las ventas
        if($cinema == "" && $movie == ""){
            
            try{
                $result = $db->getTotalTicketsSold($fromDate,$toDate);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats(-1,$result);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema != "" && $movie == ""){//solo se selecciono un cine pero no pelicula
            
            try{
                $result = $db->getTotalTicketsSoldByCinema($fromDate,$toDate,$cinema);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats(-1,$result);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema == "" && $movie != ""){
            
            try{
                $result = $db->getTotalTicketsSoldByMovie($fromDate,$toDate,$movie);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats(-1,$result);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }else if ($cinema != "" && $movie != ""){
            try{
                $result = $db->getTotalTicketsSoldByCinemaAndMovie($fromDate,$toDate,$cinema,$movie);
                if($result == null){
                    $result = 0;
                }
                $homeController->stats(-1,$result);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }
    }

    public function index(){
        
    }


}

?>