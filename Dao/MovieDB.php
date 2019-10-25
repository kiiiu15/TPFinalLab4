<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Cinema as Cinema;

class MovieDB{
    private $connection;

    public function __construct(){
    }

    public function GetAll(){
        $sql="SELECT * FROM Movies";
        try{
            $this->connection= Connection ::getInstance();
            $result= $this->connection->Execute($sql);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
    //FALTA EL LLAMADO A LA API, DE ESO TE ENCARGAS VOS BULZOMI
    public function Add($cinema){
        $sql="INSERT INTO Movies (title,language,overview,releaseDate,poster,genres) VALUES (:tittle,:language,:overview,:releaseDate,:poster,:genres)";
        $values['title']      = $cinema->getTitle();
        $values['language']    = $cinema->getLanguage();
        $values['overview']    = $cinema->getOverview();
        $values['releaseDate'] = $cinema->getReleaseDate();
        $values['poster']      = $cinema->getPoster();
        $values['genres']      = $cinema->getGenres();

        try{
            $this->connection =Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function RetrieveByGenre($genre){
        $sql="SELECT * FROM Movies WHERE Movies.genres=:genre";
        $values['genres']=$genre;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }
    
    public function RetrieveByTitle($title){
        $sql="SELECT * FROM Movies WHERE Movies.title=:title";
        $values['title']=$title;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }
    
    public function RetrieveByReleaseDate($releaseDate){
        $sql="SELECT * FROM Movies WHERE Movies.releaseDate=:releaseDate";
        $values['releaseDate']=$releaseDate;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }
    }

    public function Delete($movie){
        $sql="DELETE FROM Movies WHERE Movies.title=:title";
        $values['title'] = $movie->getTitle();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

}




?>