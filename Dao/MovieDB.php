<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Movie as Movie;
use model\Genre as Genre;
use Dao\GenreDB as GenreDB;

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
    public function Add($movie){
        $sql="INSERT INTO Movies (idMovie,tittle,language,overview,releaseDate,poster) VALUES (:idMovie,:tittle,:language,:overview,:releaseDate,:poster)";
        $values['idMovie']     = $movie->getId(); 
        $values['tittle']       = $movie->getTitle();
        $values['language']    = $movie->getLanguage();
        $values['overview']    = $movie->getOverview();
        $values['releaseDate'] = $movie->getReleaseDate();
        $values['poster']      = $movie->getPoster();
        //$values['genres']      = $movie->getGenres();

        $genrePerMovie = $movie->getGenres();






        

        try{
            $this->connection =Connection::getInstance();
            $this->connection->connect();
            $this->connection->ExecuteNonQuery($sql,$values);


            $genreDB = new GenreDB();


            foreach ($genrePerMovie as $genreMovie){
                $sql2= "INSERT INTO GenresPerMovie (idMovie, idGenre) VALUES (:idMovie,:idGenre)";
                $values2 ['idMovie'] = $movie->getId();
                $values2 ['idGenre'] = $genreMovie->getId();
    
                
                   /* $this->connection =Connection::getInstance();
                    $this->connection->connect();*/
                    $this->connection->ExecuteNonQuery($sql2,$values2);

                $genreDB->Add($genreMovie);
    
            }
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

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($m) {
            






        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }

}




?>