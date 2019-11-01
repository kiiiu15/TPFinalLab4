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

    public function Add($idFunction = 0,$idMovie = 0, $idCinema = 0, $date = "" , $hour = "" ){
        
        $MovieFunctionDB= new MovieFunctionDB();

        $MovieDB= new MovieDB();
        
        $CinemaDB= new CinemaDB();

        $movie=$MovieDB->RetrieveById($idMovie);  
        $cinema=$CinemaDB->RetrieveById($idCinema);

        $MovieFunction= new MovieFunction($idFunction,$date,$hour,$cinema,$movie);

        $MovieFunctionDB->Add($MovieFunction);
        echo "ya se nos va";
        //include(VIEWS ."/home.php");
    }

    public function GetAll(){
        $MovieFunctionDB= new MovieFunctionDB();

        $FunctionList=$MovieFunctionDB->GetAll();
        include(FRONT_ROOT ."/controllers/HomeControllers.php");
    }


    //Aun no estan Probadas 
    public function GetById($idToSearch){
        $MovieFunctionDB= new MovieFunctionDB();
        
        $function=$MovieFunctionDB->RetrieveById($idToSearch);


    }

    public function Delete($idFunction){
        $MovieFunctionDB = new MovieFunctionDB();

        $Function=$MovieFunctionDB->RetrieveById($idFunction);

        $MovieFunctionDB->Delete($Function);
    }

    public function Modify($idFunctionToModify ,$idMovie ,$idCinema ,$date ,$hour){
        $MovieFunctionDB= new MovieFunctionDB();

        $movieDB= new MovieDB();
        $cinemaDB= new CinemaDB();

        $MovieFunctionDB->Modify(new MovieFunction( $idFunctionToModify , $movieDB->RetrieveById($idMovie) , $cinemaDB->RetrieveById($idCinema) , $date , $hour));

    }


    public function index(){
        include(VIEWS . "/cinemaHome.php");
    }

}

?>