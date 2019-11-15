<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use Dao\UserDB as UserDB;
use model\Buy as Buy;
use model\User as User;

class BuyDB{
    private $connection;

    public function __construct(){

    }

    public function GetAll(){
        $sql="SELECT * FROM Buy";
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

    //En el modelo de Buy tenemos que agregar el objeto de tipo usuario
    public function Add($buy){
        $sql="INSERT INTO Buy(date,numberOfTickets,total,discount,idUser,state) VALUES(:date,:numberOfTickets,:total,:discount,:idUser,state)";
        $values['date']= $buy->getDate();
        $values['numberOfTickets']= $buy->getNumberOfTickets();
        $values['total']= $buy->getTotal();
        $values['discount']= $buy->getDiscount();
        $user= new User();
        $user=$buy->getUser();
        $values['idUser']= $user->getId(); 
        $values['state'] = $buy->getState();

        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function RetrieveById($idBuy){
        $sql="SELECT * FROM Buy WHERE Buy.idBuy=:idBuy";
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

    //Se le pasa un objeto de tipo user y obtengo su id para la busqueda en la base de datos
    public function RetrieveByUser($user){
        $sql="SELECT * FROM Buy WHERE Buy.emailUser =:emailUser ";
        $values['emailUser'] =$user->GetEmail();
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

    public function ChangeState($idBuy){ //VERIFICAR SI FUNCIONA ASI LA QUERY !!! 
        $sql="UPDATE Buy WHERE Buy.state=:true WHERE Buy.idBuy = :idBuy";
        $values['idBuy'] = $idBuy;
        $values['state'] = true;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }  
    }

    public function Delete($buy){
        $sql="DELETE FROM Buy WHERE Buy.idBuy=:idBuy";
        $values['idBuy']=$buy->getIdBuy();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    /*
    public function RetrieveByMaxCollect(){

    }*/

    public function getTotalByMovie($fromDate,$toDate,$idMovie){
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        WHERE Buy.state=true AND Buy.date BETWEEN :fromDate AND :toDate 
        AND MovieFunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getTotalByCinema($fromDate,$toDate,$cinema){
        
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        INNER JOIN Rooms
        ON MovieFunctions.idRoom = Rooms.id
        WHERE Buy.state=true AND Buy.date BETWEEN :fromDate AND :toDate 
        AND Rooms.idCinema = :idCinema";

        $values['idCinema'] = $cinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function getTotalByDate($fromDate,$toDate){
        
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        INNER JOIN Rooms
        ON MovieFunctions.idRoom = Rooms.id
        WHERE Buy.state=true AND Buy.date BETWEEN :fromDate AND :toDate"; 
        

        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getTotalByMovieAndCinema($fromDate,$toDate,$idMovie,$idCinema){
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        INNER JOIN Rooms
        ON MovieFunctions.idRoom = Rooms.id
        WHERE Buy.state=true AND Buy.date BETWEEN :fromDate AND :toDate 
        AND Rooms.idCinema = :idCinema
        AND MovieFunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    //lo tome como que busca las fechas de la compra, no de la funcion
    public function getTotalTicketsSold($fromDate,$toDate){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy WHERE Buy.date BETWEEN :fromDate AND :toDate AND Buy.state = true";

        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getTotalTicketsSoldByMovie($fromDate,$toDate,$idMovie){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction =  Moviefunctions.idFunction
        WHERE Buy.date BETWEEN :fromDate AND :toDate AND Buy.state = true AND Moviefunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex; 
        }
    }

    public function getTotalTicketsSoldByCinema($fromDate,$toDate,$idCinema){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction = Moviefunctions.idFunction
        INNER JOIN Rooms ON Moviefunctions.idRoom = Rooms.id
        WHERE Buy.date BETWEEN :fromDate AND :toDate AND Buy.state = true AND Rooms.idCinema = :idCinema";

        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function getTotalTicketsSoldByCinemaAndMovie($fromDate,$toDate,$idCinema,$idMovie){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction = Moviefunctions.idFunction
        INNER JOIN Rooms ON Moviefunctions.idRoom = Rooms.id
        WHERE Buy.date BETWEEN :fromDate AND :toDate AND Buy.state = true AND Rooms.idCinema = :idCinema 
        AND Moviefunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values)[0]['total'];
        }catch(\PDOException $ex){
            throw $ex;
        }
    }
    
    protected function Map($value) {
        $UserDB= new UserDB();
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($b) {
        return new Buy($b['idBuy'],$b['date'], $b['numberOfTickets'], $b['total'], $b['discount'], $b['price'],$UserDB->GetById($b['idUser']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }


}

?>