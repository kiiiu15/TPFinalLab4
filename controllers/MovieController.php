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
        include(VIEWS . "/home.php");
    }

}

?>