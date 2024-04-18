<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Genre as Genre;

class GenreDB {

    private $connection;

    public function __construct(){
        
    }

    public function GetAll(){
        $sql="SELECT * FROM Genres";
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);            
        }else{
             return false;
        }
    }

    public function ExtractGenrebyId($Id){
        $sql="SELECT *FROM Genres WHERE Genres.idGenre = :idGenre";
        $values['idGenre'] = $Id;
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql, $values);
        }catch(\PDOException $ex){
            throw $ex;
        }

        if(!empty($result)){
            return $this->Map($result);            
        }else{
             return false;
        }
    }

    public function GenreExist($nameToSearch){
        $sql="SELECT  IFNULL(COUNT(Genres.nameGenre), 0 ) as Cantidad FROM Genres WHERE Genres.nameGenre = :nameGenre GROUP BY Genres.nameGenre";
        $values['nameGenre'] = $nameToSearch;
        try{
            $this->connection= Connection::getInstance();
            $result = $this->connection->Execute($sql, $values);
        }catch(\PDOException $ex){
            throw $ex;
        }

        

        if(isset($result) && !empty($result) && $result[0]["Cantidad"] > 0){
            return true;            
        }else{
             return false;
        }
    }

    public function Add($genre){
        $sql="INSERT INTO Genres (idGenre , nameGenre) VALUES (:idGenre , :nameGenre)";
        $values['idGenre'] = $genre->getId();
        $values['nameGenre'] = $genre->getName();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
            return $result;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Delete($id){
        $sql="DELETE FROM Genres WHERE Genres.idGenre = :idGenre";
        $values['idGenre'] = $id;

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
            return $result;
        }catch(\PDOException $ex){
            throw $ex;
        }
       
    }

    public function Modify($genre){
        $sql = "UPDATE Genres SET Genres.nameGenre = :nameGenre WHERE Genres.idGenre = :idGenre";

        $values['idGenre'] = $genre->getId();
        $values['nameGenre'] = $genre->getName();
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->ExecuteNonQuery($sql,$values);
            return $result;
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($g) {
            return new Genre($g['idGenre'], $g['nameGenre']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}
?>