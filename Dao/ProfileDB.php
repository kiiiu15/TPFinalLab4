<?php

namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Profile as Profile;
use Dao\ProfileDB as ProfileDB;

class ProfileDB 
{
    private $connection;

    function __construct() {
    }    

    public function getAll(){

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

    
    public function add($profile){
        //se tiene que llamar pass en lugar de password, por que sino tira error, parece que es una palabra reservada
        $sql = "INSERT INTO UserProfiles (UserName,UserlastName,dni,telephoneNumber) VALUES (:UserName,:UserlastName,:dni,:telephoneNumber)";

        //$values["id"]              = $profile->getId();
        $values["UserName"]        = $profile->getName();
        $values["UserlastName"]    = $profile->getLastName();
        $values["dni"]             = $profile->getDni();
        $values["telephoneNumber"] = $profile->getTelephoneNumber();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($p) {
            return new Profile($p['UserName'], $p['UserlastName'], $p['dni'], $p['telephoneNumber']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>