<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\MovieController as MovieController;
use controllers\MovieFunctionController as MovieFunctionController;
use Dao\MovieDB as MovieDB;
use model\Movie as Movie;
use model\Genre as Genre;
use model\MovieFunction as MovieFunction; 
use Dao\MovieFunctionDB as MovieFunctionDB; 
use Dao\CinemaDB as CinemaDB;


class HomeController implements Icontrollers {

    public function showMoviesByGenre($genre) {
        $controllerMovie=new MovieController();
        if ($genre == '*'){
            $list = $controllerMovie->GetAll();
        } else {
            $list = $controllerMovie->getMovieForGenre($genre);
        }
        
        include(VIEWS."/home.php");
    }

    public function showMovie($title){
        $movieController = new MovieController();
        $movieToSearch = $movieController->GetMovieForTitle($title);
        include(VIEWS ."/showMovie.php");
    }

    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */
        /*$asd = new MovieFunctionDB();
        $qwe= new CinemaDB();
        $zxc = new MovieDB();
        $MovieFunction = new MovieFunction(2, '2019-12-25','00:00:00',$qwe->RetrieveById(1),$zxc->RetrieveById(1));
        echo "<pre>";
        print_r($asd->Add($MovieFunction));
        echo "</pre>";
    */          $MovieFunctionController = new MovieFunctionController();
        //$MovieFunctionController->Add(1,2,2,'2019-10-31','19:00');

        var_dump($MovieFunctionController->GetAll());

        if(!isset($_SESSION["status"]) || $_SESSION["status"] != "on")
        {
            require(VIEWS."/login.php");
        }//else{
            //$this->showMoviesByGenre('*');
       /* }*/

    }
}

?>