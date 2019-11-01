<?php

namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\User as User;
use model\Profile as Profile;
use model\Role as Role;

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
        }else{
            return false;
        }
    }

    
    public function Add($user,$profileId){
        //se tiene que llamar pass en lugar de password, por que sino tira error, parece que es una palabra reservada
        $sql = "INSERT INTO Users (email,pass,roleName,usersProfileId) VALUES (:email,:pass,:roleName,:usersProfileId)";

        $values["email"]           = $user->GetEmail();
        $values["pass"]            = $user->GetPass();
        $values["roleName"]        = $user->GetRole()->GetRoleName();
        $values["usersProfileId"]  = $profileId;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
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

    public function GetByEmail($email){
        $sql = "SELECT us.email,us.pass,us.roleName,p.UserName,p.UserLastName,p.Dni,p.TelephoneNumber
                FROM
                    Users AS us
                INNER JOIN
                    UserProfiles AS p
                ON us.usersProfileId = p.idProfile
                WHERE 
                    us.email = :email";
        $values['email'] = $email;

        try{
            $this->connection = Connection::getInstance();
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

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($u) {
            $profile = new Profile($u['UserName'],$u['UserLastName'],$u['Dni'],$u['TelephoneNumber']);
            $role = new Role($u['roleName']);
            return new User($u['email'], $u['pass'], $role, $profile);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>