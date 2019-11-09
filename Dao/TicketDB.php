<?php namespace Dao;

use model\Ticket as Ticket;
use model\Buy as Buy;
use Dao\BuyDB as BuyDB;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;

class TicketDB{
    private $connection;
    
    /*
    private $idTicket;
    private $QR;
    private $Buy;*/

    public function Add($ticket){
        $sql="INSERT INTO Tickets(qr,idBuy) VALUES(:qr,:idBuy)";
        $values['qr']= $ticket->getQR();
        $buy = new Buy();
        $buy = $ticket->getBuy();
        $values['idBuy']= $buy->getIdBuy();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function GetAll(){
        $sql="SELECT * FROM Tickets";
        try{
            $this->connection= Connection::getInstance();
            $result= $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveById($idTicket){
        $sql="SELECT * FROM Tickets WHERE Tickets.idTicket=:idTicket";
        $values['idTicket'] =$idTicket;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByIdBuy($idBuy){
        $sql="SELECT * FROM Tickets WHERE Tickets.idBuy=:idBuy";
        $values['idBuy'] =$idBuy;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function Delete($ticket){
        $sql="DELETE FROM Tickets WHERE Tickets.idTickets=:idTicket";
        $values['idBuy']=$buy->getIdBuy();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
}

?>