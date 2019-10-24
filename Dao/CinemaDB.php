<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Cinema as Cinema;

class CinemaDB{

    private $connection;

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

    public function RetrieveData(){
        $sql="SELECT * FROM Cinemas";
    }

    public function cinemaExist(){
        
    }
 
    public function getCinema($cinema){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExecute $ex){
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

    /*
    public function getIDCinemaActiva (){

       
    }
    
    public function getIDCinemaUnActiva(){
        
    }*/

}


?>