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
        $sql="INSERT INTO Buy(date,numberOfTickets,total,discount,idUser) VALUES(:date,:numberOfTickets,:total,:discount,:idUser)";
        $values['date']= $buy->getDate();
        $values['numberOfTickets']= $buy->getNumberOfTickets();
        $values['total']= $buy->getTotal();
        $values['discount']= $buy->getDiscount();
        $user= new User();
        $user=$buy->getUser();
        $values['idUser']= $user->getId(); 
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
        $sql="SELECT * FROM Buy WHERE Buy.idBuy=:idUser";
        $values['idUser'] =$user->getId();
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

    
    protected function Map($value) {
        $UserDB= new UserDB();
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($b) {
        return new Buy($b['idBuy'],$b['date'], $b['numberOfTickets'], $b['total'], $b['discount'], $b['price'],$UserDB->GetById($b['idUser']));
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }



}


/*class Buy    
    private $idBuy;
    private $date;
    private $numberOfTickets;
    private $total;
    private $discount;
class CreditCardPayment{
    private $date;
    private $idAuthorization;
    private $total;
    */





?>