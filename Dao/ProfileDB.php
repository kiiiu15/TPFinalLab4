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
        $sql = "INSERT INTO UserProfiles (UserName,UserlastName,dni,telephoneNumber) VALUES (:UserName,:UserlastName,:dni,:telephoneNumber)";

        $values["UserName"]        = $profile->getName();
        $values["UserlastName"]    = $profile->getLastName();
        $values["dni"]             = $profile->getDni();
        $values["telephoneNumber"] = $profile->getTelephoneNumber();

        
        
        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);

            //preguntar si esto esta bien
            $profileId = $this->getLastId();
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>ESTO ES PROFILE ID EN EL ADD DE PROFILEDB";
            var_dump( $profileId );
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
            echo "<br>";
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        return $profileId;
    }

    //supongo que hay una mejor forma de hacerlo....
    public function getLastId(){
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

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($p) {
            return new Profile($p['UserName'], $p['UserlastName'], $p['dni'], $p['telephoneNumber']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }
}

?>