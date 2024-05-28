<?php

namespace Controllers;

use \PDO as PDO;
use \Exception as Exception;
use Controllers\IControllers as IControllers;
use model\Genre as Genre;
use Dao\GenreDB as GenreDB;


class GenreController implements IControllers
{

    private GenreDB $genreDB;

    public function __construct() {
        $this->genreDB = new GenreDB();
    }


    public function add($id = 0, $name = "")
    {
        try {
            $genre = new Genre($id, $name);
            $this->genreDB->Add($genre);
        } catch (\PDOException $ex) {
            echo "Error ading genre";
        }
    }

    public function GetAll()
    {
        try {
            $genreList = $this->genreDB->GetAll();
        } catch (\PDOException $ex) {
            $genreList = array();
        }
        return $genreList;
    }

    public function index()
    {
    }

    public function RetrieveAPI()
    {
        $apiContent = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        try {
            if ($apiContent) {
                $arrayToDecode  = json_decode($apiContent, true);
                foreach ($arrayToDecode['genres'] as $genre) {
                    $newGenre = new Genre($genre["id"], $genre["name"]);
                    $this->genreDB->Add($newGenre);
                }
            }
        } catch (\PDOException $ex) {
            echo "DB connection Error";
        }
    }
}
