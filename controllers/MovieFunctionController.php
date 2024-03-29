<?php
namespace controllers;

use controllers\IControllers as IControllers;
use controllers\UserController as UserController;
use Model\Cinema as Cinema;
use Model\Movie as Movie;
use Model\MovieFunction as MovieFunction;


use Dao\RoomDB as RoomDB;
use Dao\MovieDB as MovieDB;
use Dao\MovieFunctionDB as MovieFunctionDB;

class MovieFunctionController implements IControllers{

    public function Add($idMovie = 0, $idRoom = 1, $date = "" , $hour = "" ){
    
        $MovieFunctionDB= new MovieFunctionDB();

        $MovieDB= new MovieDB();
        
        $RoomDB= new RoomDB();

        $movie=$MovieDB->RetrieveById($idMovie);  
        $room=$RoomDB->RetrieveById($idRoom);

        $MovieFunction= new MovieFunction(0,$date,$hour,$room,$movie);
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
        
        
        

        /*Obtenemos todas las demas funciones para la fecha de la funciion que queremos agregar */
        $MovieFunctionDB = new MoviefunctionDB();
        try {
            $functions = $MovieFunctionDB->RetrieveByDate($movieFunction->getDay());
        
            /*Este chequeo se realiza debido a que el Map del dao puede retornar tnato un  arreglo como un false como un solo objeto */
            $functions = $this->TransformToArray($functions);
            /*Y como vamos a usar funciones de arreglos evitamos que se rompa */
    
            /*Chequeamos que haya funciones con las qie podria haber problemas en el dia de la fecha seleccionados*/
            if (count($functions) > 0) {
                /*Verificamos que esa pelicula no se este proyectanbdo en otro cine o en otra */
                $answer = $this->CheckByRoom($movieFunction, $functions);
                /*Si es asi, verificamos la sala y los horarios de otras funciones para esa misma sala dentro del cine */
                if($answer === ''){
                    $answer = $this->CheckByFunctionsInRoom($movieFunction, $functions);
    
    
                }
    
            }
                
                
            
            /*Retornamos la respuesta que es vacio si esta todo ok, o un mensaje de error de haber alguno */
           return $answer;
        } catch (\Throwable $th) {
            return 'Connection error';
        }

        
    }

    private function CheckByFunctionsInRoom ($movieFunction, $functions){
        $answer = '';
        /*Obtenemos la sala Y el cine  */
        $room = $movieFunction->getRoom();
        $cinema = $room->getCinema();

        /*Agrupamos las funciones por cine */
        $funcionsPerCinema = $this->GroupFunctionsByCinema($functions);
        /*Definimos un arreglo vacio para las funciones que podrian llegar a generar inconvenientes con la carga de la funcion */
        $functionsForTheDay = array();

        /*Si el cine de la funcion  tiene funciones para ese dia las extraemos */
        if (isset( $funcionsPerCinema[$cinema->getIdCinema()])){

            /*Unicamente de las funciones del cine que nos interesa */
            $functionsForTheDay = $funcionsPerCinema[$cinema->getIdCinema()];



            /*Agrupamos las funciones del cine por salas */

            $functionsGroupedByRoom = $this->GroupFunctionsRoom($functionsForTheDay);

            /*Si hay funciones en la sala que nos interesa las extraemos */

            if (isset($functionsGroupedByRoom[$room->getId()]) ){
                $functionsAtRoom = $functionsGroupedByRoom[$room->getId()];

                $roomForTheDay = $functionsAtRoom[0]->getRoom();

                if ($roomForTheDay->getId() == $room->getId()){
                    $answer = $this->CheckTime($movieFunction, $functionsAtRoom);
                } else {
                    $answer = "A movie can be watch just on one specific room of an specific cinema per day";
                }
            }
        } 
        return $answer;
    }

    private function CheckByRoom ($movieFunction, $functions){
        $answer = '';
        /*Obtenemos la pelicula y el cine de la funcion */
        $movie = $movieFunction->getMovie();
        $room = $movieFunction->getRoom();
        /*Agrupamos las funciones por peliculas */
        $functionsGroupedByMovie = $this->GroupFunctionsByMovie($functions);

        /*Verificamos si hay funciones para pelicula en cuestion y las extraemos*/
        if(isset($functionsGroupedByMovie[$movie->getId()]) ){
            $movieFunctions = $functionsGroupedByMovie[$movie->getId()];
            /*Si hay al menos una funcion le extraemos el cine a la primera ya que a este punto ninguna otra funcion debera poder tener otro cine distinto */
            if (count($movieFunctions) > 0) {
                $roomOfMovieForTheDay = $movieFunctions[0]->getRoom();
                /*Comparamos que se este haciendo la agregacion en el mismo cine y si es otro significa que ya esta pelicula se esta proyectando en otro cine */
                if ($roomOfMovieForTheDay->getId() != $room->getId() ){
                    $answer = "A movie can only be played in one room per day. Change date or choose the same room.";
                }
            }
        }
            return $answer;
    }

   

    private function CheckTime($movieFunction, $functions){
        $answer = '';
        foreach ($functions as $function){

            $minTime = $this->AddTime($function->getHour(), -135);
            $maxTime = $this->AddTime($function->getHour(), 135);

            
            if ($movieFunction->getHour() > $function->getHour()) {


                if (  $movieFunction->getHour() < $maxTime){
                    
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            }else {
                if ($minTime < $movieFunction->getHour()){
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            }

            if ($movieFunction->getHour() < '02:15:00' ){
                if ($function->getHour() < '02:15:00'){
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            } elseif ( $movieFunction->getHour() > '21:45:00' ){
                if ( $function->getHour() > '21:45:00' ){
                    $answer = "The time is set with another function in the same Cinema room, please change the time or the room";
                    break;
                }
            }
            
        }

        return $answer;
    }


    private function TransformToArray($value){
        if ($value == false){
            $value = array();
        }

        if (!is_array($value)){
            $value = array($value);
        }

        return $value;

    }

    private function AddTime( $hora, $minutos_sumar ) 
    { 
       $minutoAnadir=$minutos_sumar;
       $segundos_horaInicial=strtotime($hora);
       $segundos_minutoAnadir=$minutoAnadir*60;
       $nuevaHora=date("H:i:s",$segundos_horaInicial+$segundos_minutoAnadir);
       return $nuevaHora;
    } //fin función


    public function GroupFunctionsRoom($functions){
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function){
            $room = $function->getRoom();
            $array[$room->getId()] [] = $function; 
        }

        return $array;
    }
    public function GroupFunctionsByMovie($functions){
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function){
            $movie = $function->getMovie();
            $array[$movie->getId()] [] = $function; 
        }

        return $array;
    }

    public function GroupFunctionsByCinema($functions){
        $array = array();
        $functions = $this->TransformToArray($functions);
        foreach ($functions as $function){
            $cinema = $function->getRoom()->getCinema();
            $array[$cinema->getIdCinema()] [] = $function; 
        }

        return $array;
    }

    public function GetMovieByDate($date){
        $MovieFunctionDB= new MovieFunctionDB();
        try {
            $functions = $MovieFunctionDB->RetrieveByDate($date);
            $movies = array();
            $functions = $this->TransformToArray($functions);
    
            foreach($functions as $function){
                $movie = $function->getMovie();
                $movies[$movie->getId()] = $movie;
            }
            return $movies;
        } catch (\Throwable $th) {
            return array();
        }
      
        
    }


    public function GetAll(){
        $MovieFunctionDB= new MovieFunctionDB();
        try {
            return $MovieFunctionDB->GetAll();
        } catch (\Throwable $th) {
            return array();
        }
        
    }

    public function GetBillboard(){
        $MovieFunctionDB= new MovieFunctionDB();
        try {
            $movieFunctionList= $MovieFunctionDB->RetrieveBillboard();
            return $movieFunctionList;
        } catch (\Throwable $th) {
            return array();
        }
        
    }

    public function GetBillboardMovies(){
        $functions = $this->GetBillboard();
        $functions = $this->TransformToArray($functions);
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
        try {
            return $MovieFunctionDB->RetrieveById($idToSearch);
        } catch (\Throwable $th) {
            return array();
        }
        
    }

    public function Delete($idFunction = 0){

        $MovieFunctionDB = new MovieFunctionDB();
        try {
            $idFunction = $this->TransformToArray($idFunction);
            foreach($idFunction as $id){
                $Function=$MovieFunctionDB->RetrieveById($id);
                $MovieFunctionDB->Delete($Function);
            }
            $this->index();    
        } catch (\Throwable $th) {
            $this->index("DB Connection Error");
        }
   
       
            
    }

    public function GetShowMovieInfo($idMovie) {
        $functions = $this->GetBillboard();
        $functions = $this->TransformToArray($functions);
        
        $groupedFunctions = $this->GroupFunctionsByMovie($functions);
        
        if (isset($groupedFunctions[$idMovie])){
            $movieFunctions = $groupedFunctions[$idMovie];
            $info = $this->GroupFunctionsByCinema($movieFunctions);
        } else {
            $info = array();
        }
        
        return $info;
    }

    public function prueba($param) {

    
        $a = $this->GetShowMovieInfo($param);
        
        $json =  json_encode($a, JSON_PRETTY_PRINT);

        
        echo $json;
    }


  /*  public function Modify($idFunctionToModify ,$idMovie ,$idCinema ,$date ,$hour){
        $MovieFunctionDB= new MovieFunctionDB();

        $movieDB= new MovieDB();
        $RoomDB= new RoomDB();

        $MovieFunctionDB->Modify(new MovieFunction( $idFunctionToModify , $movieDB->RetrieveById($idMovie) , $RoomDB->RetrieveById($idCinema) , $date , $hour));
    
    }*/


    public function index($mensaje = null){
        $errorMje=$mensaje;
        $roomC = new RoomController();
        $movieC = new MovieController();
        $movies = $movieC->GetAll() + $movieC->RetrieveAPI();
        $activeRooms = $roomC->RetrieveByActive(true);
        $movieFunctionList = $this->GetBillboard(); 
        
        include(VIEWS.'/addFunction.php');
    }


}

?>