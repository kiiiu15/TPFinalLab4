<?php
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\Genre as Genre;
use Dao\GenreDB as GenreDB;


class GenreController implements IControllers{

    public function add ($id = 0,$name = "") {
        
        $genreDB= new GenreDB();
        $genre= new Genre($id,$name);
        $genreDB->Add($genre);

        include(VIEWS."/home.php"); 
    }

    public function GetAll(){
        $genreDB= new GenreDB();
        $genreList= $genreDB->GetAll();
       return $genreList;
    }

    public function index(){
        include(VIEWS . "/home.php");
    }

    public function RetrieveAPI(){
        $genreDB = new GenreDB ();
        $apiContent = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=f78530630a382b20d19bddc505aac95d&language=en-US");
        if ($apiContent){
            $arrayToDecode  = json_decode($apiContent,true); 
            foreach ($arrayToDecode['genres'] as $genre){
                $newGenre = new Genre($genre["id"],$genre["name"]);
                $genreDB->Add($newGenre);
            }
        }
    }

}


?>