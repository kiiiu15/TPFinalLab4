<?php 
namespace Controllers;
use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Controllers\GenreController as GenreController;
use model\Movie as Movie;
use Dao\MovieDB as MovieDB;


class MovieController implements IControllers{

    public function add ($title = "" , $Language = "" , $overview = "" , $ReleaseDate = "" ,$Poster,$genre_ids) {
        
        $MovieDB=new MovieDB();     
        try{
            $movie=new Movie($title,$Language,$overview,$ReleaseDate,$Poster,$genre_ids);
            $MovieDB->Add($movie);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }



    //AUN NO VERIFICADAS !!!!

    public function RetrieveAPI(){
        
        $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        $movieDB = new MovieDB();
        $newMovies = array();
        try{
            if ($apiContent){

                $arrayToDecode  = json_decode($apiContent,true);
            
                
                foreach ($arrayToDecode["results"] as $movie) {
                
                    if(!$this->ExistMovie($movie["id"])) //Falta crear la validacion
                    {
                        //Falta la obtencion de generos, creo que esta mal la ultima parte ! 
                        $movie = new Movie($movie["id"], $movie["title"] , $movie["original_language"] , $movie["overview"],  $movie["release_date"] , $movie["poster_path"],$movieDB->GetObjectGenresForMovie($movie['genre_ids']));

                        $movieDB->Add($movie); 

                        $newMovies[$movie->getId()] = $movie;

                    }

                }   
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $newMovies;
    }

    public function ExistMovie($idMovie){
        $movieDB= new MovieDB();
        try{
            if ($movieDB->RetrieveById($idMovie) == false ){
                return false;
            } else {
                return true;
            }
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    //Verificar su funcionamiento, las vistas deben pedir
    //datos a la controladora, no directamente al dao
    public function GetAll(){
        try{
            $this->RetrieveAPI();
            $MovieDB = new MovieDB();
            $MovieList=$MovieDB->GetAll();

        }catch(\PDOException $ex){
            throw $ex;
        }
        return $MovieList;
    }

    //Verificar si funca 
    public function GetMovieForGenre($idGenreToSearch){
        $MovieDB=new MovieDB();
        try{
            $ListMovieGenre=$MovieDB->RetrieveByGenre($idGenreToSearch);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $ListMovieGenre;
    }

    public function GetMovieForTitle($titleMovie){
        $movieDB = new MovieDB();
        try{
            $movie = $movieDB->RetrieveByTitle($titleMovie);
        }catch(\PDOException $ex){
            throw $ex;
        }
        return $movie;
    }

    public function index(){
        $movieList = $this->GetAll();
        $genreController = new GenreController();
        $genresList = $genreController->GetAll();
        include(VIEWS.'/posts.php');
    }

}

?>