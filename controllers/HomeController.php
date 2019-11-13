<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\UserController as UserController;
use controllers\MovieController as MovieController;
use controllers\CinemaController as CinemaController;
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
        $movieList = $this->GetMovieForGenreFromBillBoard($genreId);
        $genresList = $genreC->GetAll();

        if ($movieList == false){
            $movieList = array();
            $errorMje = "Los sentimos, en cartelera no se encuentran peliculas de dicho genero.Intenete nuevamente la proxima semana.";
        }
    
        if (!is_array($movieList )){
            $movieList = array($movieList);
        }
        include(VIEWS.'/posts.php');
    }

    public function Stats(){
        $cinemaController = new CinemaController();
        $cinemaList = $cinemaController->GetAll();
        include(VIEWS."/stats.php" );
    }

    public function GetMovieForGenreFromBillBoard($genreId){
        $movieFunctionController = new MovieFunctionController();
        $moviesAtBillBoard = $movieFunctionController->GetBillboardMovies();
        $movies = array();
        foreach($moviesAtBillBoard as $movie){
            $genres = $movie->getGenres();
            foreach($genres as $genre){
                if ($genre->getId() == $genreId){
                    $movies[$movie->getId()] = $movie;
                }
            }
        }
        return $movies;
    }


    public function showMovie($idMovie){
        $movieFController = new MovieFunctionController();
        
        $movieToSearchFunctions = $movieFController->GetShowMovieInfo($idMovie);
        $this->index(null, $movieToSearchFunctions);
    }

    public function ShowMovieByDate($date){
        
        $userC = new UserController();
        $movieFC = new MovieFunctionController();
        $genreC = new GenreController();

        $isAdmin = $userC->IsAdmin();
        $movieList= $movieFC->GetMovieByDate($date);
        
        $genresList = $genreC->GetAll();

       

        if (empty($movieList)){
            $errorMje = "No hay peliculas programadas para ese dia. Intente con otra fecha";
        }

        include(VIEWS.'/posts.php');
        
        
    }

    public function index ($mensage = null, $movieFunctionsToShow= null){
        $errorMje = $mensage;
        $userC = new UserController(); 
        $movieFC = new MovieFunctionController();
        $genreC = new GenreController();

        $isAdmin = $userC->IsAdmin();
        $movieList = $movieFC->GetBillboardMovies();
        $genresList = $genreC->GetAll();
        $selectedMovieFunctions = $movieFunctionsToShow;
        //var_dump($movieList);

        include(VIEWS.'/posts.php');
    }
}

?>