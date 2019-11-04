<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Genre as Genre;

class GenresPerMovieDB {

    private $connection;

    public function __construct(){
        
    }

    public function GetAll(){
        
    }

    

    public function GenreExist($nameToSearch){
        
    }

    public function Add($genre){
            $sql = "INSERT INTO GenresPerMovie (idMovie, idGenre) VALUES (:idMovie,:idGenre)";
            
            $values ['idMovie'] = $genre->getId();
            $values ['idGenre'] = $genre->getName();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Remove($id){
        
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