<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use Dao\UserDB as UserDB;
use model\Buy as Buy;
use model\User as User;
use Dao\MovieFunctionDB as MovieFunctionDB;
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

    public function Add($buy){
        
        $sql = "INSERT INTO Buy (idBuy,idMovieFunction,buyDate,numberOfTickets,total,discount,emailUser,buyState) 
        VALUES (:idBuy,:idMovieFunction,:buyDate,:numberOfTickets,:total,:discount,:emailUser,:buyState)";

        $values['idBuy']            = $buy->getIdBuy();
        $values['idMovieFunction']  = $buy->getMovieFunction()->getId();
        $values['buyDate']          = $buy->getDate();
        $values['numberOfTickets']  = $buy->getNumberOfTickets();
        $values['total']            = $buy->getTotal();
        $values['discount']         = $buy->getDiscount();
        $values['emailUser']        = $buy->getUser()->GetEmail();
        $values['buyState']         = false;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
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

    public function Modify($buy){
        $sql="UPDATE Buy SET Buy.idMovieFunction=:idMovieFunction,Buy.date=:date,Buy.numberOfTickets=:numberOfTickets,
        Buy.total=:total,Buy.discount=:discount,Buy.emailUser=:emailUser,Buy.state=:state WHERE Buy.idBuy=:idBuy";

        $values["idMovieFunction"] = $buy->getIdMovieFunction();
        $values["date"]            = $buy->getDate();
        $values["numberOfTickets"] = $buy->getNumberOfTickets();
        $values["total"]           = $buy->getTotal();
        $values["discount"]        = $buy->getDiscount();
        $values["emailUser"]       = $buy->getEmailUser();
        $values["state"]           = $buy->getState();
        $values["idBuy"]           = $buy->getIdBuy();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return  $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }

    }

    public function ChangeState($idBuy){ //VERIFICAR SI FUNCIONA ASI LA QUERY !!! 
        $sql="UPDATE Buy SET Buy.buyState=:state WHERE Buy.idBuy = :idBuy";
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
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
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
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

        
    }

    public function getTotalByDate($fromDate,$toDate){
        
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        INNER JOIN Rooms
        ON MovieFunctions.idRoom = Rooms.id
        WHERE Buy.Buystate=true AND Buy.buydate BETWEEN :fromDate AND :toDate"; 
        

        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }

    public function getTotalByMovieAndCinema($fromDate,$toDate,$idMovie,$idCinema){
        $sql = "SELECT SUM(Buy.total) AS total FROM 
        Buy INNER JOIN MovieFunctions 
        ON Buy.idMovieFunction = MovieFunctions.idFunction
        INNER JOIN Rooms
        ON MovieFunctions.idRoom = Rooms.id
        WHERE Buy.buystate=true AND Buy.buydate BETWEEN :fromDate AND :toDate 
        AND Rooms.idCinema = :idCinema
        AND MovieFunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }

    //lo tome como que busca las fechas de la compra, no de la funcion
    public function getTotalTicketsSold($fromDate,$toDate){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy WHERE Buy.buydate BETWEEN :fromDate AND :toDate AND Buy.buystate = true";

        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }

    public function getTotalTicketsSoldByMovie($fromDate,$toDate,$idMovie){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction =  Moviefunctions.idFunction
        WHERE Buy.buydate BETWEEN :fromDate AND :toDate AND Buy.buystate = true AND Moviefunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex; 
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }

    public function getTotalTicketsSoldByCinema($fromDate,$toDate,$idCinema){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction = Moviefunctions.idFunction
        INNER JOIN Rooms ON Moviefunctions.idRoom = Rooms.id
        WHERE Buy.buydate BETWEEN :fromDate AND :toDate AND Buy.buystate = true AND Rooms.idCinema = :idCinema";

        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }

    public function getTotalTicketsSoldByCinemaAndMovie($fromDate,$toDate,$idCinema,$idMovie){
                
        $sql = "SELECT SUM(Buy.numberOfTickets) AS 'total' FROM
        Buy INNER JOIN Moviefunctions ON Buy.idMovieFunction = Moviefunctions.idFunction
        INNER JOIN Rooms ON Moviefunctions.idRoom = Rooms.id
        WHERE Buy.buydate BETWEEN :fromDate AND :toDate AND Buy.buystate = true AND Rooms.idCinema = :idCinema 
        AND Moviefunctions.idMovie = :idMovie";

        $values['idMovie'] = $idMovie;
        $values['idCinema'] = $idCinema;
        $values['fromDate'] = $fromDate;
        $values['toDate'] = $toDate;
            
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $result[0]['total'];
        }else{
            return 0;
        }

    }
    
    protected function Map($value) {
        
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($b) {
            $UserDB= new UserDB();
            $MovieFunctionDB = new MovieFunctionDB();

            return new Buy($b['idBuy'],$MovieFunctionDB->RetrieveById($b['idMovieFunction']),$b['buyDate'], $b['numberOfTickets'], $b['total'], $b['discount'] ,$UserDB->GetByEmail($b['emailUser']), $b['buyState']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }


}

?>