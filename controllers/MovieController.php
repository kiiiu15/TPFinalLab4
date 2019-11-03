<?php 
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\Movie as Movie;
use Dao\MovieDB as MovieDB;


class MovieController implements IControllers{

    public function add ($title = "" , $Language = "" , $overview = "" , $ReleaseDate = "" ,$Poster,$genre_ids) {
        
        $MovieDB=new MovieDB();     
        $movie=new Movie($title,$Language,$overview,$ReleaseDate,$Poster,$genre_ids);
        $MovieDB->Add($movie);
        include(VIEWS."/home.php"); 
    }



    //AUN NO VERIFICADAS !!!!

    public function RetrieveAPI(){
        
        $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        $movieDB = new MovieDB();
        if ($apiContent){

            $arrayToDecode  = json_decode($apiContent,true);
            
            foreach ($arrayToDecode["results"] as $movie) {
                if(!$this->ExistMovie($movie["id"])) //Falta crear la validacion
                {
                    //Falta la obtencion de generos, creo que esta mal la ultima parte ! 
                    $movie = new Movie($movie["id"], $movie["title"] , $movie["original_language"] , $movie["overview"],  $movie["release_date"] , $movie["poster_path"],$movieDB->GetObjectGenresForMovie($movie['genre_ids']));
                    var_dump($movie);
                    $movieDB->Add($movie); 
                }
            }
            
        }

    }

    public function ExistMovie($idMovie){
        $movieDB= new MovieDB();
        if ($movieDB->RetrieveById($idMovie) == false ){
            return false;
        } else {
            return true;
        }
    }

    //Verificar su funcionamiento, las vistas deben pedir
    //datos a la controladora, no directamente al dao
    public function GetAll(){
        $MovieDB=new MovieDB();
        $MovieList=$MovieDB->GetAll();
        return $MovieList;
    }

    //Verificar si funca 
    public function GetMovieForGenre($idGenreToSearch){
        $MovieDB=new MovieDB();
        $ListMovieGenre=$MovieDB->RetrieveByGenre($idGenreToSearch);
        return $ListMovieGenre;
    }

    public function GetMovieForTitle($titleMovie){
        $movieDB = new MovieDB();
        $movie = $movieDB->RetrieveByTitle($titleMovie);
        return $movie;
    }

    public function index(){
        
        //echo "gg perry";
        //include(VIEWS . "/home.php");
    }

}

?>