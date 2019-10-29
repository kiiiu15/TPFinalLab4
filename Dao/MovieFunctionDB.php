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


    //cambiar por moviefunction
    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($c) {
            return new Cinema($c['idCinema'], $c['name'], $c['address'], $c['capacity'], $c['price'], $c['active']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}























?>