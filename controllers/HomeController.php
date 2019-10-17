<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use Dao\MovieDao as MovieDao;

class HomeController implements Icontrollers {

    //Verificar si funca 
    public function getMovieForGenre($idGenreToSearch){
        $movieRepo=new MovieDao();
        $ListMovieGenre=$movieRepo->getMovieForGenre($idGenreToSearch);
        //include_once(VIEWS ."/home.php");
        //return $ListMovieGenre;
    }

    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */

        if(!isset($_SESSION["status"]) || $_SESSION["status"] != "on")
        {
            require(VIEWS."/login.php");
        }else{
            include(VIEWS."/home.php");
        }

    }
}

?>