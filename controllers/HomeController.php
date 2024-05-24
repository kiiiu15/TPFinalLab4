<?php

namespace controllers;

use controllers\Icontrollers as Icontrollers;
use controllers\SessionManager as SessionManager;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\GenreController as GenreController;

class HomeController implements Icontrollers
{

    private MovieFunctionController $movieFunctionController;
    private SessionManager $sessionManager;
    private GenreController $genreController;

    public function __construct()
    {
        $this->movieFunctionController = new MovieFunctionController();
        $this->sessionManager = SessionManager::getInstance();
        $this->genreController = new GenreController();
    }

    public function showMoviesByGenre($genreId)
    {
        $movieList = $this->GetMovieForGenreFromBillBoard($genreId);
        $movieList = $this->TransformToArray($movieList);

        if (empty($movieList)) {
            $this->index('There are no movies of this genre scheduled. Try another genre', null, null, array());
        } else {
            $this->index(null, null, null, $movieList);
        }
    }



    public function GetMovieForGenreFromBillBoard($genreId)
    {
        $moviesAtBillBoard = $this->movieFunctionController->GetBillboardMovies();
        $movies = array();
        foreach ($moviesAtBillBoard as $movie) {
            $genres = $movie->getGenres();
            foreach ($genres as $genre) {
                if ($genre->getId() == $genreId) {
                    $movies[$movie->getId()] = $movie;
                }
            }
        }
        return $movies;
    }

    private function TransformToArray($value)
    {
        if ($value == false) {
            $value = array();
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        return $value;
    }


    public function showMovie($idMovie)
    {
        $movieToSearchFunctions = $this->movieFunctionController->GetShowMovieInfo($idMovie);
        $this->index(null, $movieToSearchFunctions);
    }

    public function ShowMovieByDate($date)
    {
        $movieList = $this->movieFunctionController->GetMovieByDate($date);

        if (empty($movieList)) {
            $this->index("There are no movies scheduled for that day. Try another date", null, null, array());
        } else {
            $this->index(null, null, null, $movieList);
        }
    }

    public function index($errorMje = null, $movieFunctionsToShow = null, $successMje = null, $movieListPassed = array())
    {
        $genresList = $this->genreController->GetAll();
        $isAdmin = $this->sessionManager->IsAdmin();

        if (empty($movieListPassed)) {
            $movieList = $this->movieFunctionController->GetBillboardMovies();
        } else {
            $movieList = $movieListPassed;
        }

        $selectedMovieFunctions = $movieFunctionsToShow;
        $selectedMovieFunctions = $this->TransformToArray($selectedMovieFunctions);

        include(PAGES . '/home.php');
    }
}
