<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use model\Buy as Buy;
use model\MovieFunction as MovieFunction;
use model\User as User;
use model\Cinema as Cinema;
use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;

class BuyController implements Icontrollers{

    public function NewBuy($idFunction,$numberOfTickets){

        //obtenemos al usuario
        $UserController = new UserController();
        $user = $UserController->GetUserLoged();

        //si no estuviera logueado no deberia de poder ni acceder a este metodo, pero por las dudas agrego esta validacion
        if($user){

            //obtenemos la funcion para la que decea hacer la compra
            $moviefunctionController = new MovieFunctionController();
            $movieFunction = $moviefunctionController->GetById($idFunction);

            //primero que nada tenemos que haya disponibilidad para la cantidad de entradas seleccionadas
            if($moviefunctionController->GetRemainingCapacity($numberOfTickets) < -1){

                //ACORDARSE DE SETEAR LA NUEVA REMAININGCAPACITY SI ES Q SE REALIZA LA COMPRA....
                $total = $movieFunction->getCinema()->getPrice() * $numberOfTickets;

                /**
                 * verificar descuento
                 */

                                //supongo que es la fecha de la compra, y no de la funcion
                $buy = new Buy(0,getdate(),$numberOfTickets,$total,$discount,$user);
            }else{
                $errorCapacityMSG = "no hay tantas entradas disponibles";
                //INCLUIR LA VISTA Y HACER EL SCRIPT DE ALERT....
            }

            
            

        //moviefunction
            //id
            //day
            //hour
            //cinema
            //movie
            
        //buy
            //idBuy
            //MovieFunction
            //date
            //numberOfTickets
            //total
            //discount
            //user
        }else{
            include(VIEWS."/login.php");
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

    

    public function index(){
        
    }


}

?>