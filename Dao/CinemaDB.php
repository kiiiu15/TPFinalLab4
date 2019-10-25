<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Cinema as Cinema;

class CinemaDB{

    private $connection;

    public function __construct(){
    }

    public function GetAll(){
        $sql="SELECT *FROM Cinemas";
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

    public function Add($cinema){
        $sql= "INSERT INTO Cinemas (idCinema,name,address,capacity,price,active) VALUES (:idCinema,:name,:addres,:capacity,:price,:active)";
        $values['idCinema']   = $cinema->getIdCinema();
        $values['name']       = $cinema->getName();
        $values['address']    = $cinema->getAddress();
        $values['capacity']   = $cinema->getCapacity();
        $values['price']      = $cinema->getPrice();
        $values['active']     = $cinema->getActive();

        try{
            $this->connection= Conection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql, $values);
        }
        catch(\PDOException $ex) {
            throw $ex;
        }
    }

    public function Deactivate($cinema){
        $sql="UPDATE Cinemas set Cinemas.active=false WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function ChangePrice($cinema){
        $sql="UPDATE Cinemas set Cinemas.price=:price WHERE Cinemas.idCinema=:idCinema";
        $values['price'] =$cinema->getPrice();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function ChangeAddress($cinema){
        $sql="UPDATE Cinemas set Cinemas.address=:address WHERE Cinemas.idCinema=:idCinema";
        $values['address'] =$cinema->getAddress();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Delete($cinema){
        $sql="DELETE FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    /* Se guarda cuando se agrega, asi que no es necesario
    public function SaveData(){
        
    }*/

    public function RetrieveByAddress($address){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.address=:address";
        $values['address']=$address;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    //puede ser activado o desactivado
    public function RetrieveByActive($active){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.active=:active";
        $values['active']=$active;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connect->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveById($id){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:id";
        $values['idCinema']=$id;

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveByName($name){
        $sql="SELECT *FROM Cinemas WHERE Cinemas.name=:name";
        $values['name'] =$name;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    //Creo que hay que fletar esta funcion
    public function cinemaExist(){
        
    }
 
    public function getCinema($cinema){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    //Se va a utilizar un auto_increment para los ids
    /*public function generateIdCinema(){
        
    }*/

    //En la parte de la VIEW, no se le debe permitir modificar el id del cine
    //por ende esta funcion recibe el cine con los datos modificados y conservando el id
    //name,address,capacity,price,active 
    public function modify($cinema){
        $sql="UPDATE FROM Cinemas SET Cinemas.name=:name,Cinemas.address=:address,Cinemas.capacity=:capacity,Cinemas.price=:price WHERE Cinemas.idCinema=:idCinema";
        $values['name']     = $cinema->getName();
        $values['address']  = $cinema->getAddress();
        $values['capacity'] = $cinema->getCapacity();
        $values['price']    = $cinema->getPrice();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    
    public function getIDCinemaActiva ($active){
        $sql="SELECT Cinemas.idCinema FROM Cinemas WHERE Cinemas.active=:active";
        $values['active']=$active;
        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute();
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }
  
    //Ver despues su funcionamiento
    /*protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new Cinema($c['idCinema'], $c['name'], $c['address'], $c['capacity'], $c['price'], $c['active']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }*/

}


?>