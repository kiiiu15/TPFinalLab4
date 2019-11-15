<?php namespace Dao;

use model\Ticket as Ticket;
use model\Buy as Buy;
use Dao\BuyDB as BuyDB;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;

class TicketDB{
    private $connection;


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
    public function Modify($ticket){
        $sql = "UPDATE Tickets SET Tickets.qr=:qr,Tickets.idBuy=:idBuy WHERE Tickets.id = :id";

        $values['qr'] = $ticket->getQR();
        $values['idBuy'] = $ticket->getBuy()->getIdBuy();
        $values['id'] = $ticket->getIdTicket();
        
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
        $sql="DELETE FROM Tickets WHERE Tickets.idTicket=:idTicket";
        $values['idTickets']=$ticket->getIdTicket();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        $buyDB= new BuyDB();
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($b) {
        return new Ticket($b['idTicket'],$b['qr'],$buyDB->RetrieveById($b['idBuy']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}

?>