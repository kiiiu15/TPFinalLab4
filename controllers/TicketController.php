<?php namespace controllers;

use phpqrcode\QRcode as QRcode;
use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use controllers\BuyController as BuyController;

use model\Buy as Buy;
use model\MovieFunction as MovieFunction;
use model\User as User;
use model\Ticket as Ticket;

use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;
use Dao\TicketDB as TicketDB;

class TicketController implements Icontrollers{


    public function Add($ticket){
        $ticketDB = new TicketDB();

        try{
            $ticketDB->Add($ticket);
        }catch(\PDOException $ex){
            echo "Error connection";
        }
    }

    public function GetAll(){
        $ticketDB = new TicketDB();
        $ticketList = array();

        try{
            $ticketList = $ticketDB->GetAll();
            return $ticketList;
        }catch(\PDOException $ex){
            return array();
        }
        
    }

    public function Delete($ticket){
        $ticketDB = new TicketDB();
        try{
            $ticketDB->Delete($ticket);
        }catch(\PDOException $ex){
            echo "Error Coneection";
        }
    }

    public function RetrieveById($idTicket){
        $ticketDB = new TicketDB();
        $ticket = new Ticket();
        try{
            $ticket = $ticketDB->RetrieveById($idTicket);
            return $ticket;
        }catch(\PDOException $ex){
            return null;
        }
        
    }

    public function RetrieveByIdBuy($idBuy){
        $ticketDB = new TicketDB();
        $ticket = new Ticket();
        try{
            $ticket = $ticketDB->RetrieveByIdBuy($idBuy);
            return $ticket;
        }catch(\PDOException $ex){
            return null;
        }
        
    }

    public function RetrieveByUser($user){
        $ticketDB = new TicketDB();
        try {
            return $ticketDB->RetrieveByUser($user);
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function GenerateRandomString($length = 4) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } 

    public function GenerateQR($randomString){
        $dir = 'QRS/';
        if(!file_exists($dir)){
            mkdir($dir);
        }else{
            $filename = $dir .$randomString .'.png';
            $tamanio = 10;
            $level = 'M';
            $frameSize = 3;
            $content = $randomString;

            QRcode::png($content, $filename, $level , $tamanio , $frameSize);
        }
    }

  


    public function index(){}
}










?>