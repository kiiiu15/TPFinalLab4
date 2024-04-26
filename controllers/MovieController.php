<?php

namespace Controllers;

use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use Controllers\GenreController as GenreController;
use model\Movie as Movie;
use Dao\MovieDB as MovieDB;


class MovieController implements IControllers
{

    public function add($title = "", $Language = "", $overview = "", $ReleaseDate = "", $Poster, $genre_ids)
    {

        $MovieDB = new MovieDB();
        try {
            $movie = new Movie($title, $Language, $overview, $ReleaseDate, $Poster, $genre_ids);
            $MovieDB->Add($movie);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }



    //AUN NO VERIFICADAS !!!!

    public function RetrieveAPI()
    {
        try {
            $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        } catch (Exception $e) {
            $apiContent = array();
        }

        $movieDB = new MovieDB();
        $newMovies = array();
        try {
            if ($apiContent) {

                $arrayToDecode  = json_decode($apiContent, true);


                foreach ($arrayToDecode["results"] as $movie) {

                    if (!$this->ExistMovie($movie["id"])) //Falta crear la validacion
                    {
                        //Falta la obtencion de generos, creo que esta mal la ultima parte ! 
                        $movie = new Movie($movie["id"], $movie["title"], $movie["original_language"], $movie["overview"],  $movie["release_date"], $movie["poster_path"], $movieDB->GetObjectGenresForMovie($movie['genre_ids']));

                        $movieDB->Add($movie);

                        $newMovies[$movie->getId()] = $movie;
                    }
                }
            }
            return $newMovies;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    public function ExistMovie($idMovie)
    {
        $movieDB = new MovieDB();
        try {
            if ($movieDB->RetrieveById($idMovie) == false) {
                return false;
            } else {
                return true;
            }
        } catch (\PDOException $ex) {
            throw $ex; /*Lo agarra la otra controller que lo llama */
        }
    }

    //Verificar su funcionamiento, las vistas deben pedir
    //datos a la controladora, no directamente al dao
    public function GetAll()
    {
        try {
            $this->RetrieveAPI();
            $MovieDB = new MovieDB();
            $MovieList = $MovieDB->GetAll();
            return $MovieList;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    //Verificar si funca 
    public function GetMovieForGenre($idGenreToSearch)
    {
        $MovieDB = new MovieDB();
        try {
            $ListMovieGenre = $MovieDB->RetrieveByGenre($idGenreToSearch);
            return $ListMovieGenre;
        } catch (\PDOException $ex) {
            return array();
        }
    }

    public function GetMovieForId($id)
    {
        $MovieDB = new MovieDB();
        try {
            $movie = $MovieDB->RetrieveById($id);
            return $movie;
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function GetMovieForTitle($titleMovie)
    {
        $movieDB = new MovieDB();
        try {
            $movie = $movieDB->RetrieveByTitle($titleMovie);
            return $movie;
        } catch (\PDOException $ex) {
            return null;
        }
    }

    public function index()
    {
        $movieList = $this->GetAll();
        $genreController = new GenreController();
        $genresList = $genreController->GetAll();
        include(PAGES . '/posts.php');
    }


    public function prueba($param)
    {


        $a = $this->GetMovieForId($param);

        $json =  json_encode($a, JSON_PRETTY_PRINT);


        echo $json;
    }
}
