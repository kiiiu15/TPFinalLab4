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

        $MovieFunction= new MovieFunction(0,$date,$hour,$cinema,$movie);
        $answer = $this->CheckMovieFunction($MovieFunction);
        if ($answer === true){
            $MovieFunctionDB->Add($MovieFunction);
            $this->index();
        } else {
            $this->index($answer);
        }
       
        
        
    }

    public function CheckMovieFunction ($movieFunction) {
        $answer = true;
        $movie = $movieFunction->getMovie();
        $cinema = $movieFunction->getCinema();
        $MovieFunctionDB = new MoviefunctionDB();
        $functions = $MovieFunctionDB->RetrieveByDate($movieFunction->getDay());
        if ($functions == false){
            $functions = array();
        }

        if (!is_array($functions)){
            $functions = array($functions);
        }

        if (count($functions) > 0) {
            $grupedFunctions = $this->GroupFunctionsByMovie($functions);

            if(isset($grupedFunctions[$movie->getId()])){
                $movieFunctions = $grupedFunctions[$movie->getId()];


                if (count($movieFunctions) > 0){
                    $CinemaOfMovieForTheDay = $movieFunctions[0]->getCinema();
                    var_dump($cinema);
                    if ($CinemaOfMovieForTheDay->getIdCinema() == $cinema->getIdCinema() ){
                       
                        foreach($movieFunctions as $Function){
                            $fechaMinima = strtotime('+2 hours', $Function->getHour());
                            /*if (strtotime($movieFunction->getHour()) > (strtotime($Function->getHour()))->Modify('- 2 hours')->Modify('-15 minute') || strtotime($movieFunction->getHour())  <  strtotime(($Function->getHour()))->Modify('+2 hours')->Modify('+15 minute')){
                                $answer = "La hora se pisa con otra funcion en el mismo Cine, por favor cambie la hora";
                                break;
                            }*/
                        }
                    }else{
                        echo 'entro al if';
                        $answer="La Pelicula solo puede ser proyectada en un solo cine por dia, cambie el cine o la fecha";
                    }
                }


            }      
        }

        
       return $answer;
        
    }

    public function GroupFunctionsByMovie($functions){
        $array = array();
        foreach ($functions as $function){
            $movie = $function->getMovie();
            $array[$movie->getId()] [] = $function; 
        }

        return $array;
    }

    public function GetMovieByDate($date){
        $MovieFunctionDB= new MovieFunctionDB();
        $functions = $MovieFunctionDB->RetrieveByDate($date);
        $movies = array();

        foreach($functions as $function){
            $movie = $function->getMovie();
            $movies[$movie->getId()] = $movie;
        }

        return $movies;
    }


    public function GetAll(){
        $MovieFunctionDB= new MovieFunctionDB();

        return $MovieFunctionDB->GetAll();
    }

    public function GetBillboard(){
        $MovieFunctionDB= new MovieFunctionDB();

        $movieFunctionList= $MovieFunctionDB->RetrieveBillboard();
        return $movieFunctionList;
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


    public function index($mensaje = null){
        $errorMje=$mensaje;
        $cinemaC = new CinemaController();
        $movieC = new MovieController();
        $movies = $movieC->GetAll() + $movieC->RetrieveAPI();
        $activeCinemas = $cinemaC->RetrieveByActive(true);
        $movieFunctionList = $this->GetBillboard();
        include(VIEWS.'/addFunction.php');
    }

}

?>