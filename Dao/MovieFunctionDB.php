<?php
namespace Dao;

use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\MovieFunction as MovieFunction;

class MovieFunctionDB{

    private $connection;

    public function __construct(){
    }

    /* ASI ESTA EN MI MYSQL (SANTI) puede estar distinto en el que hiciste Agus! ! 
    idFunction int not null auto_increment,
    dayFunction varchar(10),
    hourFunction varchar(10),
    movies varchar(40),
    cinema int,
    */
    public function GetAll(){
        $sql="SELECT * FROM MovieFunctions";
        try{
            $this->connection= Connection::getInstance();
            $result=$this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    //MOVIES ES EL TITULO DE LA PELICULA, CINEMA ES EL ID DEL CINEMA (ESTAS SERIAN LAS FK DE LA TABLA MOVIE FUNCTIONS)
    public function Add($moviefunction){
        $sql="INSERT INTO MovieFunctions(idFunction,dayFunction,hourFunction,movies,cinema) VALUES (:idFunction,:dayFunction,:hourFunction,:movies,:cinema)";
        $values['idFunction']   =$moviefunction->getId();
        $values['dayFunction']  =$moviefunction->getDay();
        $values['hourFunction'] =$moviefunction->getHour();
        $values['movies']       =$moviefunction->getMovie(); //Tendria que el objeto movie dentro de movie function, obtener el id de la pelicula
        $values['cinema']       =$moviefunction->getCinema();//Lo mismo !

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function Modify($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.dayFunction=:dayFunction, MovieFunctions.hourFunction=:hourFunction,MovieFunctions.movies=:movies,MovieFunctions.cinema=:cinema WHERE MovieFunctions.idFunction=:idFunction";
        $values['dayFunction']   =$moviefunction->getDay();
        $values['hourFunction']  =$moviefunction->getHour();
        $values['movies']        =$moviefunction->getMovie();
        $values['cinema']        =$moviefunction->getCinema();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function ChangeCinema($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.cinema=:cinema WHERE MovieFunctions.idFunction=:idFunction";
        $values['cinema'] =$moviefunction->getCinema();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function ChangeDay($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.dayFunction=:dayFunction WHERE MovieFunctions.idFunction=:idFunction";
        $values['dayFunction'] =$moviefunction->getDay();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function ChangeHour($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.hourFunction=:hourFunction WHERE MovieFunctions.idFunction=:idFunction";
        $values['hourFunction'] =$moviefunction->getHour();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function Delete($moviefunction){
        $sql="DELETE FROM MovieFunctions WHERE MovieFunctions.idFunction=:idFunction";
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeception $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByDate($moviefunction){
        $sql="SELECT FROM MovieFunctions WHERE MovieFunctions.dayFunction=:dayFunction";
        $values['dayFunction'] =$moviefunction->getDay();

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

    public function RetrieveByCinema($moviefunction){
        $sql="SELECT FROM MovieFunctions WHERE MovieFunctions.cinema=:cinema";
        $values['cinema']=$moviefunction->getCinema();
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

    public function RetrieveByMovie($moviefunction){
        $sql="SELECT FROM MovieFunctions WHERE MovieFunctions.movie=:movie";
        $values['movie'] =$moviefunction->getMovie();
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

    //Levanta 
    public function RetrieveBillboard(){
        $sql="SELECT FROM MovieFunctions WHERE MovieFunctions.dayFunction BETWEEN CURDATE() AND CURDATE() +INTERVAL 7 DAY";
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql);
        }catch(\PDOExeception $ex){
            throw $ex;
        }if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    //cambiar por moviefunction
    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($m) {
            return new MovieFunction($m['idFunction'], $m['dayFunction'], $m['hourFunction'], $m['movies'], $m['cinema']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}























?>