<?php

namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\User as User;
use Dao\ProfileDB as ProfileDB;

class UserDB{
    private $connection;

    function __construct() {
    }    

    /*
    funciona bien pero no me gusta como devuelve el resultado 
    */
    public function GetAll(){

        $sql="SELECT * FROM Users";

        try{
            $this->connection = Connection ::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    
    public function Add($user){
        //se tiene que llamar pass en lugar de password, por que sino tira error, parece que es una palabra reservada
        $sql = "INSERT INTO Users (email,pass,roleName,usersProfileId) VALUES (:email,:pass,:roleName,:usersProfileId)";

        $values["email"]           = $user->getEmail();
        $values["pass"]            = $user->getPass();
        $values["roleName"]        = $user->getRole()->getRoleName();
        //esto esta mal, pero no se bien como resolverlo 
        //$profile=$user->getProfile();
        //$values['usersProfileId']=$profile->getName(); //No te funcionaria asi ?  ya que le estas devolviendo un objeto de tipo profile
        $values["usersProfileId"]  = $user->getProfile()->getName();
        

        //aca no se si deberia llamar a un ProfileDB que haga su propio add?
      /*  $DAO = new ProfileDB();
        $DAO->add($user->getProfile());*/

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function DeleteByEmail($email){
        $sql = "DELETE FROM Users WHERE Users.email = :email";
        $values['email'] = $email;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function GetById($idUser){
        $sql = "SELECT * FROM Users WHERE Users.idUser = :idUser";
        $values['idUser'] = $idUser;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($u) {
            return new User($u['email'], $u['pass'], $u['roleName'], $u['usersProfileId']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>