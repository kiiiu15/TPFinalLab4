<?php namespace controllers;

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
            throw $ex;
        }
    }

    public function GetAll(){
        $ticketDB = new TicketDB();
        $ticketList = array();

        try{
            $ticketList = $ticketDB->GetAll();
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $ticketList;
    }

    public function Delete($ticket){
        $ticketDB = new TicketDB();
        try{
            $ticketDB->Delete($ticket);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveById($idTicket){
        $ticketDB = new TicketDB();
        $ticket = new Ticket();
        try{
            $ticket = $ticketDB->RetrieveById($idTicket);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $ticket;
    }

    public function RetrieveByIdBuy($idBuy){
        $ticketDB = new TicketDB();
        $ticket = new Ticket();
        try{
            $ticket = $ticketDB->RetrieveByIdBuy($idBuy);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $ticket;
    }

    public function index(){}
}










?>