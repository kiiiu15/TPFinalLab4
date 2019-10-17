<?php 
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\Movie as Movie;
use Dao\MovieDao as MovieDao;


class MovieController implements IControllers{

    public function add ($title = "" , $Language = "" , $overview = "" , $ReleaseDate = "" ,$Poster,$genre_ids) {
        
        $MovieDao=new MovieDao();     
        $movie=new Movie($title,$Language,$overview,$ReleaseDate,$Poster,$genre_ids);
        $MovieDao->Add($movie);
        include(VIEWS."/home.php"); 
    }

    //Verificar su funcionamiento, las vistas deben pedir
    //datos a la controladora, no directamente al dao
    public function GetAll(){
        $MovieDao=new MovieDao();
        $MovieList=$MovieDao->GetAll();
        return $MovieList;
    }


    public function index(){
        include(VIEWS . "/home.php");
    }

}

?>