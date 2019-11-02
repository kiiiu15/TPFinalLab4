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
        include(VIEWS ."/home.php");
    }

    public function index(){
        include(VIEWS . "/home.php");
    }

}


?>