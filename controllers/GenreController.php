<?php
namespace Controllers;

use Controllers\IControllers as IControllers;
use model\Genre as Genre;
use Dao\GenreDao as GenreDao;


class GenreController implements IControllers{

    public function add ($idApi = 0,$name = "") {
        
        $genreRepo=new GenreDao();     
        $genre=new Genre($idApi,$name);
        $genreRepo->Add($genre);
        include(VIEWS."/home.php"); 
    }

    public function GetAll(){
        $genreRepo=new GenreDao();  
        $genreList=$genreRepo->GetAll();
        return $genreList;
    }

    public function GetGenere($nameGenre){
        $genreRepo=new GenreDao();
        //Si el genero existe
        if($genreRepo->GenreExist($nameGenre)){
            //Una vez enlazemos los generos con las peliculas, aca tendra que hacer una comparacion
            //y los idGenero dentro de la clase de pelicula comparando con los idgenero de genero
            //Los guardamos en un array y los retornamos para la vista 
        }
    }

    public function index(){
        include(VIEWS . "/home.php");
    }

}

















?>