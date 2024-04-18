<?php

namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Profile as Profile;

class ProfileDB 
{
    private $connection;

    function __construct() {
    }    

    public function GetAll(){

        $sql="SELECT * FROM UserProfiles";

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

    
    public function Add($profile){
        $sql = "INSERT INTO UserProfiles (UserName,UserlastName,dni,telephoneNumber) VALUES (:UserName,:UserlastName,:dni,:telephoneNumber)";

        $values["UserName"]        = $profile->GetName();
        $values["UserlastName"]    = $profile->GetLastName();
        $values["dni"]             = $profile->GetDni();
        $values["telephoneNumber"] = $profile->GetTelephoneNumber();
      
        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);

            $profileId = $this->GetLastId();
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        return $profileId;
    }

    //supongo que hay una mejor forma de hacerlo....
    public function GetLastId(){
        $sql = "SELECT MAX(idProfile) AS idProfile FROM UserProfiles";

        try{
            $this->connection = Connection ::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOExeption $ex){
            throw $ex;
        }if(!empty($result)){
            return $result[0][0];
        }else{
            return false;
        }
    }

    public function GetProfileById($idProfile){
        
        $sql = "SELECT * FROM UserProfiles up WHERE up.idProfile = :idProfile";
        $values['idProfile'] = $idProfile;

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
    
    public function Modify($profile){
        $sql = "UPDATE UserProfiles SET UserProfiles.UserName=:UserName,UserProfiles.UserLastName=:UserLastName,
        UserProfiles.dni=:Dni,UserProfiles.telephoneNumber=:telephoneNumber
        WHERE UserProfiles.idProfile=:idProfile";

        $values['UserName'] = $profile->getUserName();
        $values['UserLastName'] = $profile->getUserLastName();
        $values['Dni'] = $profile->getDni();
        $values['telephoneNumber'] = $profile->getTelephoneNumber();
        $values['idProfile'] = $profile->getIdProfile();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
            return $result;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Delete($profileId){
        $sql = "DELETE FROM UserProfiles WHERE UserProfiles.idProfile = :idProfile";

        $values['idProfile'] = $profileId;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
            return $result;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($p) {
            return new Profile($p['idProfile'],$p['UserName'], $p['UserlastName'], $p['dni'], $p['telephoneNumber']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>