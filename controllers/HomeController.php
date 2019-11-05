<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\UserController as UserController;
use controllers\MovieController as MovieController;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\GenreController as GenreController; 
use Dao\MovieDB as MovieDB;
use model\Movie as Movie;
use model\Genre as Genre;
use model\Cinema as Cinema;
use model\MovieFunction as MovieFunction; 
use Dao\MovieFunctionDB as MovieFunctionDB; 
use Dao\CinemaDB as CinemaDB;



class HomeController implements Icontrollers {

    public function showMoviesByGenre($genreId) {

        $userC = new UserController();
        $movieC = new MovieController();
        $genreC = new GenreController();

        $isAdmin = $userC->IsAdmin();
        $movieList = $movieC->GetMovieForGenre($genreId);
        $genresList = $genreC->GetAll();
        include(VIEWS.'/posts.php');
    }


    public function showMovie($title){
        $movieController = new MovieController();
        $movieToSearch = $movieController->GetMovieForTitle($title);
        include(VIEWS ."/showMovie.php");
    }

    public function ShowMovieByDate($date){
        $userC = new UserController();
        $movieFC = new MovieFunctionController();
        $genreC = new GenreController();

        $isAdmin = $userC->IsAdmin();
        $movieList= $movieFC->GetMovieByDate($date);
     


        $genresList = $genreC->GetAll();
        
        include(VIEWS.'/posts.php');
    }

    public function index (){
        
        $userC = new UserController(); 
        $movieC = new MovieController();
        $genreC = new GenreController();

        $isAdmin = $userC->IsAdmin();
        $movieList = $movieC->GetAll();
        $genresList = $genreC->GetAll();

        //var_dump($movieList);

        include(VIEWS.'/posts.php');
    }
}

?>