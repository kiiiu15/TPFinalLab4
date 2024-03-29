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
        $sql = "SELECT * FROM GenresPerMovie";

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

    

    public function GenreExist($nameToSearch){
        
    }

    public function Add($idMovie,$genre){
            $sql = "INSERT INTO GenresPerMovie (idMovie, idGenre) VALUES (:idMovie,:idGenre)";
            
            $values ['idMovie'] = $idMovie;
            $values ['idGenre'] = $genre->getId();

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public function Modify($oldIdMovie,$oldIdGenre,$newMovie,$newGenre){
        $sql = "UPDATE GenresPerMovie SET GenresPerMovie.idMovie=:idMovie, GenresPerMovie.idGenre=:idGenre
        WHERE GenresPerMovie.idMovie=:oldIdMovie AND GenresPerMovie.idGenre=:oldIdGenre";

        $values['idMovie'] = $newMovie;
        $values['idGenre'] = $newGenre;
        $values['oldIdMovie'] = $oldIdMovie;
        $values['oldIdGenre'] = $oldIdGenre;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    public function Delete($idMovie,$idGenre){
        $sql = "DELETE FROM GenresPerMovie WHERE GenresPerMovie.idMovie = :idMovie AND GenresPerMovie.idGenre = :idGenre";

        $values['idMovie'] = $idMovie;
        $values['idGenre'] = $idGenre;

        try{
            $this->connection = Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
    }

    protected function Map($value) {
        $db = new GenreDB();
        return $db->Map($value);
        /*$value = is_array($value) ? $value : [];
        $resp = array_map(function ($g) {
            return new Genre($g['idGenre'], $g['nameGenre']);
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];*/
    }

}
?>