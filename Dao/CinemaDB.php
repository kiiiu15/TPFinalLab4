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
        $sql="SELECT * FROM Cinemas";
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
        $sql= "INSERT INTO Cinemas (nameCinema,adressCinema,active) VALUES (:nameCinema,:address,:active)";

        $values['nameCinema'] = $cinema->getName();
        $values['address']    = $cinema->getAddress();
        $values['active']     = $cinema->getActive();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql, $values);
            return $result;
        }
        catch(\PDOException $ex) {
            throw $ex;
        }
    }
    
    public function DeactivateByID($idCinema){
        $sql="UPDATE Cinemas set Cinemas.active=:false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = false;
        $values['idCinema'] = $idCinema;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
           return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function ReactivateByID($idCinema){
        $sql="UPDATE Cinemas set Cinemas.active=:false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = true;
        $values['idCinema'] = $idCinema;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
           return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function Deactivate($cinema){
        $sql="UPDATE Cinemas set Cinemas.active= :false WHERE Cinemas.idCinema=:idCinema";
        $values['false'] = false;
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
       
    }



    public function ChangeAddress($cinema){
        $sql="UPDATE Cinemas set Cinemas.adressCinema=:address WHERE Cinemas.idCinema=:idCinema";
        $values['address'] =$cinema->getAddress();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    //No creo que la necesitemos
    public function Delete($cinema){
        $sql="DELETE FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }



    public function RetrieveByAddress($address){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.adressCinema=:address";
        $values['address']=$address;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    //puede ser activado o desactivado
    public function RetrieveByActive($active){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.active=:active";
        $values['active']=$active;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveById($id){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:id";
        $values['id']=$id;

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByName($nameCinema){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.nameCinema=:nameCinema";
        $values['nameCinema'] =$nameCinema;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }


 
    //Se va a utilizar un auto_increment para los ids
    /*public function generateIdCinema(){
        
    }*/

    //En la parte de la VIEW, no se le debe permitir modificar el id del cine
    //por ende esta funcion recibe el cine con los datos modificados y conservando el id
    //name,address,capacity,price,active 
    public function Modify($cinema){

        
        $sql="UPDATE  Cinemas SET Cinemas.nameCinema=:nameCinema,Cinemas.adressCinema=:address WHERE Cinemas.idCinema=:idCinema";
        $values['nameCinema']     = $cinema->getName();
        $values['address']  = $cinema->getAddress();
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return  $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    
    public function GetIDCinemaActiva (){
        $cinemas = $this->RetrieveByActive(true);
        $ids = array();
        foreach($cinemas as $cinema) {
            array_push($ids, $cinema->getIdCinema());
        }
        return $ids;
    }
    
    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new Cinema($c['idCinema'], $c['nameCinema'], $c['adressCinema'], (($c['active'] == 1) ? true : false));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}


?>