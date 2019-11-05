<?php
namespace Dao;

use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\MovieFunction as MovieFunction;
use model\Movie as Movie;
use model\Cinema as Cinema;
use Dao\MovieDB as MovieDB;
use Dao\CinemaDB as CinemaDB;
class MovieFunctionDB{

    private $connection;

    public function __construct(){
    }

    public function GetAll(){
        $sql="SELECT * FROM MovieFunctions";
        try{
            $this->connection= Connection::getInstance();
            $result=$this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
   //MOVIES ES EL TITULO DE LA PELICULA, CINEMA ES EL ID DEL CINEMA (ESTAS SERIAN LAS FK DE LA TABLA MOVIE FUNCTIONS)
   public function Add($moviefunction){
        
        $sql="INSERT INTO MovieFunctions(date,hour,idCinema,idMovie) VALUES (:dayFunction,:hourFunction,:cinema,:movies)";
        $values['dayFunction']  =$moviefunction->getDay();
        $values['hourFunction'] =$moviefunction->getHour();
        $movie =$moviefunction->getMovie(); 
        $cinema=$moviefunction->getCinema();
        $values['cinema']     =$cinema->getIdCinema();
        $values['movies']      =$movie->getId(); 
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
        return $this->connection->ExecuteNonQuery($sql,$values);

        }catch(PDOExeption $ex){
            throw $ex;
        }
    }


    public function RetrieveById($id){
        $sql="SELECT * FROM MovieFunctions WHERE MovieFunctions.idFunction=:id";
        $values['id'] =$id;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        
        
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
    public function Modify($moviefunction ){
        $sql="UPDATE MovieFunctions SET MovieFunctions.date=:date , MovieFunctions.hour=:hour , MovieFunctions.idMovie=:movies , MovieFunctions.idCinema=:cinema WHERE MovieFunctions.idFunction=:idFunction";
        $values['date']   =$moviefunction->getDay();
        $values['hour']  =$moviefunction->getHour();
        $movie =$moviefunction->getMovie(); 
        $cinema=$moviefunction->getCinema();
        $values['cinema']     =$cinema->getIdCinema();
        $values['movies']      =$movie->getId();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function Delete($moviefunction ){
        $sql="DELETE FROM MovieFunctions WHERE MovieFunctions.idFunction=:idFunction";
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeception $ex){
            throw $ex;
        }
    }

    public function ChangeCinema($moviefunction) {
        $sql="UPDATE MovieFunctions SET MovieFunctions.idCinema=:cinema WHERE MovieFunctions.idFunction=:idFunction";
        $cinema = $moviefunction->getCinema();
        $values['cinema'] = $cinema->getIdCinema();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }


    

    public function ChangeDay($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.date=:dayFunction WHERE MovieFunctions.idFunction=:idFunction";
        $values['dayFunction'] =$moviefunction->getDay();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function ChangeHour($moviefunction){
        $sql="UPDATE MovieFunctions SET MovieFunctions.hour=:hourFunction WHERE MovieFunctions.idFunction=:idFunction";
        $values['hourFunction'] =$moviefunction->getHour();
        $values['idFunction'] =$moviefunction->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }


    public function RetrieveByDate($date){
        $sql="SELECT * FROM MovieFunctions WHERE MovieFunctions.date=:date";
        $values['date'] =$date;

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

    public function RetrieveByCinema($cinema){
        $sql="SELECT * FROM MovieFunctions WHERE MovieFunctions.idCinema=:cinema";
        $values['cinema'] = $cinema->getIdCinema();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByMovie($movie){
        $sql="SELECT * FROM MovieFunctions WHERE MovieFunctions.idMovie=:movie";
        $values['movie'] =$movie->getId();
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    //Levanta la cartelera apartir de hoy a 7 dias 
    public function RetrieveBillboard(){
        $sql="SELECT * FROM MovieFunctions WHERE MovieFunctions.date BETWEEN CURDATE() AND CURDATE() +INTERVAL 7 DAY";
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql);
        }catch(\PDOExeception $ex){
            throw $ex;
        }
        
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveBillboardMovies () {
        $functions = $this->RetrieveBillboard();
        $moviesAtBillboard = array();

        foreach($functions as $function) {
            $movie = $function->getMovie();
            $moviesAtBillboard[$movie->getId()] = $movie;
        }

        return $moviesAtBillboard;
    }
    
    //agregar los pdo de movie y cinema para agregar al moviefunction los objetos de movie y cinema
    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        

        $resp = array_map(function ($m) {
            $movieDB = new MovieDB();
            $cinemaDB = new CinemaDB();
            return new MovieFunction($m["idFunction"], $m['date'], $m['hour'], $cinemaDB->RetrieveById($m['idCinema']),$movieDB->RetrieveById($m['idMovie']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}























?>