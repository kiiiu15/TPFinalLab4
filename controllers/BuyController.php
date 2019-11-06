<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use model\Buy as Buy;
use model\User as User;
use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;

class BuyController implements Icontrollers{
    /*private $idBuy;
    private $date;
    private $numberOfTickets;
    private $total;
    private $discount;
    private $user;*/

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