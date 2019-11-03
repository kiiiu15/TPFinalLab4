<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\MovieController as MovieController;
use controllers\MovieFunctionController as MovieFunctionController;
use Dao\MovieDB as MovieDB;
use model\Movie as Movie;
use model\Genre as Genre;
use model\Cinema as Cinema;
//use controllers\GenreController as GenreController; 
use model\MovieFunction as MovieFunction; 
use Dao\MovieFunctionDB as MovieFunctionDB; 
use Dao\CinemaDB as CinemaDB;


class HomeController implements Icontrollers {

    public function showMoviesByGenre($genre) {

        
        echo 'fin';
         /*if ($genre == '*'){
            $list = $controllerMovie->GetAll();
        } else {
            $list = $controllerMovie->getMovieForGenre($genre);
        }*/
        
        //include(VIEWS."/home.php");
    }

    public function showMovie($title){
        $movieController = new MovieController();
        $movieToSearch = $movieController->GetMovieForTitle($title);
        include(VIEWS ."/showMovie.php");
    }

    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */
       
        /*if(!isset($_SESSION["status"]) || $_SESSION["status"] != "on")
        {
            require(VIEWS."/login.php");
        }*/
        
        //else{
            $this->showMoviesByGenre('*');
       /* }*/

    }
}

?>