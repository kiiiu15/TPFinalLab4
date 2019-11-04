<?php
namespace Dao;
use \PDO as PDO;
use \Exception as Exception;
use Dao\QueryType as QueryType;
use model\Movie as Movie;
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
        $values['tittle']      = $movie->getTitle();
        $values['language']    = $movie->getLanguage();
        $values['overview']    = $movie->getOverview();
        $values['releaseDate'] = $movie->getReleaseDate();
        $values['poster']      = explode ('https://image.tmdb.org/t/p/w200', $movie->getPoster()) [1];

        $genrePerMovie = $movie->getGenres();

        try{
            $this->connection =Connection::getInstance();
            $this->connection->connect();
            echo $this->connection->ExecuteNonQuery($sql,$values);


            $genreDB = new GenreDB();


            foreach ($genrePerMovie as $genreMovie){

                $genreDB->Add($genreMovie);
                $sql2= "INSERT INTO GenresPerMovie (idMovie, idGenre) VALUES (:idMovie,:idGenre)";
                $values2 ['idMovie'] = $movie->getId();
                $values2 ['idGenre'] = $genreMovie->getId();

                $this->connection->ExecuteNonQuery($sql2,$values2);

                
    
            }
        }catch(\PDOExeption $ex){
            throw $ex;
        }


    }

    public function RetrieveById($idMovie){
        $sql="SELECT * FROM Movies WHERE Movies.idMovie=:idMovie";
        $values['idMovie']=$idMovie;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }


        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    public function RetrieveByGenre($genreId){
        $sql="SELECT * FROM Movies INNER JOIN GenresPerMovie ON Movies.idMovie = GenresPerMovie.idMovie INNER JOIN Genres ON GenresPerMovie.idGenre = Genres.idGenre WHERE Genres.idGenre = :idGenre";
        $values['idGenre']=$genreId;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
           $result= $this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }

        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
    public function RetrieveByTitle($title){
        $sql="SELECT * FROM Movies WHERE Movies.tittle=:title";
        $values['title']=$title;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }


        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }
    
    public function RetrieveByReleaseDate($releaseDate){
        $sql="SELECT * FROM Movies WHERE Movies.releaseDate=:releaseDate";
        $values['releaseDate']=$releaseDate;
        try{
            $this->connection=Connection::getInstance();
            $this->connection->connect();
            $result=$this->connection->Execute($sql,$values);
        }catch(\PDOExeption $ex){
            throw $ex;
        }

        if(!empty($result)){
            return $this->Map($result);
        }else{
            return false;
        }
    }

    /*Medio que esto no sirve en el sentido de que si ya la usamos esta peli tenemos aunque sea unos minimos datos relevantes */
    public function Delete($movie){

        $sql="DELETE FROM Movies WHERE Movies.title=:title";
        $values['title'] = $movie->getTitle();

        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    protected function Map($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function ($m) {
            return new Movie ($m['idMovie'],$m['tittle'],$m['language'],$m['overview'], $m['releaseDate'], $m['poster'], $this->GetGenresForMovie($m['idMovie']));    
        }, $value);
        return count($resp) > 1 ? $resp : $resp['0'];
    }


    /* Esta funcion tiene por finalidad recuperar TODOS los ids de genreos qe tenga asociada la pelicula con id que se reciba por parametro*/
    public function GetGenresIdsForMovie ($idMovie) {
        $sql = "SELECT idGenre FROM GenresPerMovie WHERE GenresPerMovie.idMovie = :idMovie";
        $values ["idMovie"] = $idMovie;
        try{
            $this->connection= Connection::getInstance();
            $this->connection->connect();
            $result = $this->connection->Execute($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }

        $genresIDs = [];
        foreach($result as $genreArray){
            $genresIDs[] = $genreArray["idGenre"]; 
        }

        return $genresIDs;

    }

    /*En esta funcion usamos la funcion de arriba para crear un arreglo de objetos Genre que estan asignados a un idMovie */

    public function GetGenresForMovie($idMovie) {
        $genresIds = $this->GetGenresIdsForMovie($idMovie);
        return $this->GetObjectGenresForMovie($genresIds);
    }

    public function GetObjectGenresForMovie ($genreIdsForTheMovie){
        $genreDB = new GenreDB();
        $genresForMovie = array();
        foreach ($genreIdsForTheMovie as $genreId) {
            $genre = $genreDB->ExtractGenrebyId($genreId);
            array_push($genresForMovie, $genre);
        }
        return $genresForMovie;
    }

}









?>