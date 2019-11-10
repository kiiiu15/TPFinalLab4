<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Room as Room;
use model\Cinema as Cinema;


class RoomDB{
    private $connection;
 
    public function __construct(){}
    
    public function GetAll(){
        $sql="SELECT * FROM Rooms";
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);            
        }else{
            return false;
        }
    }

    /**
     * no se si le corresponde a roomBd pero por ahora lo dejo aca
     */
    public function GetTotalTicketsByFunction($idFunction){
        $sql = "SELECT SUM(Buy.numberOfTickets) AS totalNumberOfTickets FROM Buy WHERE buy.idMovieFunction = :idMovieFunction";
        $values["idMovieFunction"] = $idFunction;
        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Add($room){
        $sql="INSERT INTO Rooms(name,price,capacity,idCinema) VALUES(:name,:price,:capacity,:idCinema)";
        $values['name'] = $room->getId();
        $values['price'] = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $cinema = new Cinema();
        $cinema =  $room->getCinema();
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveByID($idRoom){
        $sql="SELECT * FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $idRoom;
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);            
        }else{
            return false;
        }
    }

    //Trae todas las salas de un mismo cine :D, pronto le daremos un uso
    public function RetrieveByIdCinema($idCinema){
        $sql="SELECT * FROM Rooms WHERE Rooms.idCinema=:idCinema";
        $values['idCinema'] = $idCinema;
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);            
        }else{
            return false;
        }
    }

    public function Delete($room){
        $sql="DELETE FROM Rooms WHERE Rooms.id=:id";
        $values['id'] = $room->getId();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Modify($room){
        $sql="UPDATE  Rooms SET Rooms.name=:name,Rooms.price=:price,Rooms.capacity = :capacity,Rooms.idCinema=:idCinema WHERE Rooms.id=:id";
        $values['id']       = $room->getId();
        $values['name']     = $room->getName();
        $values['price']    = $room->getPrice();
        $values['capacity'] = $room->getCapacity();
        $values['idCinema'] = $room->getIdCinema();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return  $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
       
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            $cinemaDB = new CinemaDB();
            return new Room($c['id'], $c['name'], $c['price'], $c['capacity'],$cinemaDB->RetrieveById($C['idCinema']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }



    





}



?>