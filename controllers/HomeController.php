<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\MovieController as MovieController;


class HomeController implements Icontrollers {

    public function showMoviesByGenre($genre) {
        $list=array();
        $controllerMovie=new MovieController();
        if ($genre == '*'){
            $list = $controllerMovie->GetAll();
        } else {
            $list = $controllerMovie->getMovieForGenre($genre);
        }
        
        include(VIEWS."/home.php");
    }

    public function showMovie($title){
        $movieToSearch=array();
        $list=array();
        $controllerMovie=new MovieController();
        $list=$controllerMovie->GetAll();
        
        foreach($list as $movie){
            if($title == $movie->getTitle()){
                $movieToSearch=$movie;
            }
        }
        include(VIEWS ."/showMovie.php");
    }

    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */

        if(!isset($_SESSION["status"]) || $_SESSION["status"] != "on")
        {
            require(VIEWS."/login.php");
        }else{
            $this->showMoviesByGenre('*');
        }

    }
}

?>