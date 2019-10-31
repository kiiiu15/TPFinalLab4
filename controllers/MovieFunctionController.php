<?php
namespace controllers;

use controllers\IControllers as IControllers;
use Model\Cinema as Cinema;
use Model\Movie as Movie;
use Model\MovieFunction as MovieFunction;

use Dao\CinemaDB as CinemaDB;
use Dao\MovieDB as MovieDB;
use Dao\MovieFunctionDB as MovieFunctionDB;

class MovieFunctionController implements IControllers{

    public function Add($idMovie = 0, $idCinema = 0, $date = "" , $hour = "" ){
        
        $MovieFunctionDB= new MovieFunctionDB();

        $MovieDB= new MovieDB();
        
        $CinemaDB= new CinemaDB();

        $movie=$MovieDB->RetrieveById($idMovie);  
        $cinema=$CinemaDB->RetrieveById($idCinema);

        $MovieFunction= new MovieFunction(10,$date,$hour,$cinema,$movie);

        $MovieFunctionDB->Add($MovieFunction);

        //include(VIEWS ."/");
    }

    public function GetAll(){
        $MovieFunctionDB= new MovieFunctionDB();

        $FunctionList=$MovieFunctionDB->GetAll();
    }

    public function Delete($idFunction){
        $MovieFunctionDB = new MovieFunctionDB();

        //$Function=$MovieFunctionDB->RetrieveById($idFunction); AUN SIN HACER HASTA QUE BULZOMI PUSHEE

        $MovieFunctionDB->Delete($Function);
    }



    public function index(){
        include(VIEWS . "/cinemaHome.php");
    }

}

?>