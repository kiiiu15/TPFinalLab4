<?php

namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\User as User;
use model\Profile as Profile;

class UserDB 
{
    private $connection;

    function __construct() {
    }    

    public function GetAll(){

        $sql =  "SELECT us.email,us.pass,us.roleName,p.UserName,p.UserLastName,p.Dni,p.TelephoneNumber
                    FROM
                        Users AS us
                    INNER JOIN
                        UserProfiles AS p
                    ON us.usersProfileId = p.idProfile";

        try{
            $this->connection = Connection ::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
            //return $result;
        }else{
            return false;
        }
    }

    
    public function Add($user,$profileId){
        //se tiene que llamar pass en lugar de password, por que sino tira error, parece que es una palabra reservada
        $sql = "INSERT INTO Users (email,pass,roleName,usersProfileId) VALUES (:email,:pass,:roleName,:usersProfileId)";

        $values["email"]           = $user->getEmail();
        $values["pass"]            = $user->getPass();
        $values["roleName"]        = $user->getRole()->getRoleName();
        $values["usersProfileId"]  = $profileId;

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
            $profile = new Profile($u['UserName'],$u['UserLastName'],$u['Dni'],$u['TelephoneNumber']);
            return new User($u['email'], $u['pass'], $u['roleName'], $profile);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>