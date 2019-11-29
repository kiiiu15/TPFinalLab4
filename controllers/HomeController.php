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

        $movieC = new MovieController();

        $movieList = $this->GetMovieForGenreFromBillBoard($genreId);
    

        $movieList = $this->TransformToArray($movieList);

        if (empty($movieList)){
            $this->index('There are no movies of this genre scheduled. Try another genre', null,null,array());
        }else {
            $this->index(null, null,null, $movieList);
        }        
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

    private function TransformToArray($value){
        if ($value == false){
            $value = array();
        }

        if (!is_array($value)){
            $value = array($value);
        }

        return $value;

    }


    public function showMovie($idMovie){
        $movieFController = new MovieFunctionController();
        
        $movieToSearchFunctions = $movieFController->GetShowMovieInfo($idMovie);
        $this->index(null, $movieToSearchFunctions);
    }

    public function ShowMovieByDate($date){
        
        $movieFC = new MovieFunctionController();
        
        $movieList= $movieFC->GetMovieByDate($date);
        
       

       

        if (empty($movieList)){
            $this->index("There are no movies scheduled for that day. Try another date", null, null, array() );
        
        }else {
            $this->index(null, null, null, $movieList );
        
        }

        
        
    }

    public function index ($mensage = null, $movieFunctionsToShow= null, $mensageSucces = null, $movieListPassed = array()){
       
        $errorMje = $mensage;
        $successMje = $mensageSucces;
        $userC = new UserController(); 
        $genreC = new GenreController();
        $genresList = $genreC->GetAll();
        $isAdmin = $userC->IsAdmin();

        
       
            if (empty($movieListPassed)){
                $movieFC = new MovieFunctionController();
                $movieList = $movieFC->GetBillboardMovies();
            } else {
                $movieList = $movieListPassed;
            }
       
        
        
        $selectedMovieFunctions = $movieFunctionsToShow;
        $selectedMovieFunctions = $this->TransformToArray($selectedMovieFunctions);

        include(VIEWS.'/posts.php');

    }
}

?>