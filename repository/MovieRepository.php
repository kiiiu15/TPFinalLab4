<?php
namespace repository;
include_once("config/autoload.php");
use config\autoload as autoload;
autoload::Start();

use repository\IRepository as IRepository;
use model\Movie as Movie;

class MovieRepository implements IRepository{
    private $movieList=array();

    public function GetAll(){
        $this->RetrieveData();
        return $this->movieList;
    }

    public function Add($movie){
        $this->RetrieveData();
        array_push($this->movieList,$movie);
        $this->SaveData();
    }

    //Se busca por nombre de pelicula
    public function Delete($movieName){
        $this->RetrieveData();
        foreach($this->movieList as $key =>$movie){
            if($movie->getNombre() == $movieName){
                unset($this->movieList[$key]);
                break;
            }
        }
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode =array();
        
        foreach($this->movieList as $movie){
            $valuesArray = array();
            $valuesArray["title"]=$movie->getNombre();
            $valuesArray["original_language"]=$movie->getIdioma();
            $valuesArray["overview"]=$movie->getDescripcion();
            $valuesArray["release_date"]=$movie->getFechaEstreno();
            $valuesArray["poster_path"]=$movie->getPoster();
            
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/movie.json',$jsonContent);
    } 


    public function retrieveApi(){
        $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
            
            if ($apiContent){
                //Si apiContent tiene datos, se decodifica
                $arrayToDecode  = json_decode($apiContent,true);    

                $arrayToEncode =array();

                foreach ($arrayToDecode["results"] as $peli) {
                    $valuesArray = array();
                    $valuesArray["title"]               =  $movie["title"];
                    $valuesArray["original_language"]   =  $movie["original_language"];
                    $valuesArray["overview"]            =  $movie["overview"];
                    $valuesArray["release_date"]        =  $movie["release_date"];
                    $valuesArray["poster_path"]         =  $movie["poster_path"];

                    $movie = new Movie($movie["title"],$movie["original_language"],$movie["overview"],$movie["release_date"],$movie["poster_path"]);
                    array_push($this->movieList, $movie); 

                    array_push($arrayToEncode,$valuesArray);
                }
                //creamos el json con toda la info de la api
                $newjsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
                file_put_contents(dirname(__DIR__) . '/data/movie.json',$newjsonContent);
            }
    }

    public function RetrieveData(){
        $this->movieList=array();
        //Si existe el archivo
        if(file_exists(dirname(__DIR__) ."/data/movie.json")){
            $jsonContent = file_get_contents(dirname(__DIR__) . "/data/movie.json");
            //Si tiene datos el archivo
            if ($jsonContent) {
                //Lo decodifica
                $arrayToDecode = json_decode($jsonContent,true);

                foreach($arrayToDecode as $movie)
                {
                    $movie = new Movie($movie["title"],null,$movie["original_language"],$movie["overview"],$movie["release_date"],$movie["poster_path"]);
                    array_push($this->movieList, $movie);   
                }
            }
            else {
                $this->retrieveApi();
            }
            
        }else{
            //Sino llama a la API y le devuelve el JSON que se aloja en apiContent
            $this->retrieveApi();
        }  
    }

    public function getMovieList(){
        return $this->movieList;
    }

    //Todo
    //public function actualizar lista de peliculas <3

}


?>