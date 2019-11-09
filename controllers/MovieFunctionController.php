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
        if ($answer === ''){
            $MovieFunctionDB->Add($MovieFunction);
            $this->index();
        } else {
            $this->index($answer);
        }
       
        
        
    }


    public function CheckMovieFunction ($movieFunction) {
        $answer = '';
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
            $asd = $this->GroupFunctionsByCinema($functions);
            $functionsForTheDay = array();
            if (isset( $asd[$cinema->getIdCinema()])){
                $functionsForTheDay = $asd[$cinema->getIdCinema()];
            } 
            

            foreach($functionsForTheDay as $Function){
                $minTime = $this->AddTime($Function->getHour(), -135);
                $maxTime = $this->AddTime($Function->getHour(), 135);

                
                if ($movieFunction->getHour() < $Function->getHour()) {
                    if (  $movieFunction->getHour() < $maxTime){
                        $answer = "La hora se pisa con otra funcion en el mismo Cine, por favor cambie la hora";
                        break;
                    }
                }else {
                    if ($minTime < $movieFunction->getHour()){
                        $answer = "La hora se pisa con otra funcion en el mismo Cine, por favor cambie la hora";
                        break;
                    }
                }
               
            }

     

            if(isset($grupedFunctions[$movie->getId()]) ){
                $movieFunctions = $grupedFunctions[$movie->getId()];

                if (count($movieFunctions) > 0){
                    $CinemaOfMovieForTheDay = $movieFunctions[0]->getCinema();
                    
                    if ($CinemaOfMovieForTheDay->getIdCinema() == $cinema->getIdCinema() ){
                        foreach($movieFunctions as $Function){
                            $minTime = $this->AddTime($Function->getHour(), -135);
                            $maxTime = $this->AddTime($Function->getHour(), 135);

                            if ($movieFunction->getHour() < $Function->getHour()) {
                                if (  $movieFunction->getHour() < $maxTime){
                                    $answer = "La hora se pisa con otra funcion en el mismo Cine, por favor cambie la hora";
                                    break;
                                }
                            }else {
                                if ($minTime < $movieFunction->getHour()){
                                    $answer = "La hora se pisa con otra funcion en el mismo Cine, por favor cambie la hora";
                                    break;
                                }
                            }
                            
                    
            
                           
                        }
                        
                    } else {
                        $answer = "Una pelicula solo se puede pasar en un solo cine por dia. Cambia de fecha o pone el mismo cine. ";
                    }
                }


            }      
        }

        
       return $answer;
        
    }

    private function AddTime( $hora, $minutos_sumar ) 
    { 
       $minutoAnadir=$minutos_sumar;
       $segundos_horaInicial=strtotime($hora);
       $segundos_minutoAnadir=$minutoAnadir*60;
       $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
       return $nuevaHora;
    } //fin función

    public function GroupFunctionsByMovie($functions){
        $array = array();
        foreach ($functions as $function){
            $movie = $function->getMovie();
            $array[$movie->getId()] [] = $function; 
        }

        return $array;
    }

    public function GroupFunctionsByCinema($functions){
        $array = array();
        foreach ($functions as $function){
            $cinema = $function->getCinema();
            $array[$cinema->getIdCinema()] [] = $function; 
        }

        return $array;
    }

    public function GetMovieByDate($date){
        $MovieFunctionDB= new MovieFunctionDB();
        $functions = $MovieFunctionDB->RetrieveByDate($date);
        $movies = array();
        if ($functions === false){
            $functions = array();
        }

        if (!is_array($functions)){
            $functions = array($functions);
        }

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

    public function GetBillboardMovies(){
        $functions = $this->GetBillboard();
        if ($functions === false){
            $functions = array();
        }

        if (!is_array($functions)){
            $functions = array($functions);
        }
        $movies = array();
        foreach($functions as $function){
            $movie = $function->getMovie();
            $movies[$movie->getId()] = $movie;
        }
        return $movies;
    }


    //Aun no estan Probadas 
    public function GetById($idToSearch){
        $MovieFunctionDB= new MovieFunctionDB();
        
        return $MovieFunctionDB->RetrieveById($idToSearch);
    }

    public function Delete($idFunction = 0){
        $MovieFunctionDB = new MovieFunctionDB();
        if (is_array($idFunction)){
            foreach($idFunction as $id){
                $Function=$MovieFunctionDB->RetrieveById($id);
                $MovieFunctionDB->Delete($Function);
            }
        }else {
            $Function=$MovieFunctionDB->RetrieveById($idFunction);
            if ($Function === false){
                $Function = new MovieFunction();
            }
            $MovieFunctionDB->Delete($Function);
        }
       
        $this->index();        
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