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

    public function getAll(){
        $sql="SELECT *FROM Cinemas";
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->map($result);            
        }else{
             return false;
        }
    }

    public function add($cinema){
        $sql= "INSERT INTO Cinemas (idCinema,nameCinema,address,capacity,price,active) VALUES (:idCinema,:nameCinema,:address,:capacity,:price,:active)";
        $values['idCinema']   = $cinema->getIdCinema();
        $values['nameCinema'] = $cinema->getName();
        $values['address']    = $cinema->getAddress();
        $values['capacity']   = $cinema->getCapacity();
        $values['price']      = $cinema->getPrice();
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
    
    public function deactivateByID($idCinema){
        $sql="UPDATE Cinemas set Cinemas.active=false WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $idCinema;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    public function deactivate($cinema){
        $sql="UPDATE Cinemas set Cinemas.active=false WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    public function changePrice($cinema){
        $sql="UPDATE Cinemas set Cinemas.price=:price WHERE Cinemas.idCinema=:idCinema";
        $values['price'] =$cinema->getPrice();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    public function changeAddress($cinema){
        $sql="UPDATE Cinemas set Cinemas.address=:address WHERE Cinemas.idCinema=:idCinema";
        $values['address'] =$cinema->getAddress();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    //No creo que la necesitemos
    public function delete($cinema){
        $sql="DELETE FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    /* Se guarda cuando se agrega, asi que no es necesario
    public function SaveData(){
        
    }*/

    public function retrieveByAddress($address){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.address=:address";
        $values['address']=$address;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    //puede ser activado o desactivado
    public function retrieveByActive(){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.active=:active";
        $values['active']=true;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connect->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    public function retrieveById($id){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:id";
        $values['idCinema']=$id;

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    public function retrieveByName($nameCinema){
        $sql="SELECT *FROM Cinemas WHERE Cinemas.nameCinema=:nameCinema";
        $values['nameCinema'] =$nameCinema;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }

    //Creo que hay que fletar esta funcion
    /*public function cinemaExist(){
        
    }*/
 
    public function getCinema($cinema){
        $sql="SELECT * FROM Cinemas WHERE Cinemas.idCinema=:idCinema";
        $values['idCinema'] = $cinema->getIdCinema();

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
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
    public function modify($cinema){
        $sql="UPDATE FROM Cinemas SET Cinemas.nameCinema=:nameCinema,Cinemas.address=:address,Cinemas.capacity=:capacity,Cinemas.price=:price WHERE Cinemas.idCinema=:idCinema";
        $values['nameCinema']     = $cinema->getName();
        $values['address']  = $cinema->getAddress();
        $values['capacity'] = $cinema->getCapacity();
        $values['price']    = $cinema->getPrice();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }/*if(!empty($result)){
            return $this->map($result);
        }*/
    }

    
    public function getIDCinemaActiva ($active){
        $sql="SELECT Cinemas.idCinema FROM Cinemas WHERE Cinemas.active=:active";
        $values['active']=$active;
        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$value);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->map($result);
        }else{
            return false;
        }
    }
    
    protected function map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new Cinema($c['idCinema'], $c['nameCinema'], $c['address'], $c['capacity'], $c['price'], $c['active']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}


?>