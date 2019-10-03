<?php
namespace repository;
include_once("config/autoload.php");
use config\autoload as autoload;
autoload::Start();

use repository\IRepository as IRepository;
use model\Pelicula as Pelicula;

class PeliRepository implements IRepository{
    private $movieList=array();

    public function GetAll(){
        $this->RetrieveData();
        return $this->movieList;
    }

    public function Add($value){
        $this->RetrieveData();
        array_push($this->movieList,$value);
        $this->SaveData();
    }

    //Se busca por nombre de pelicula
    public function Delete($value){
        $this->RetrieveData();
        foreach($this->movieList as $key =>$movie){
            if($movie->getNombre() == $value){
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
            $valuesArray["nombre"]=$movie->getNombre();
            $valuesArray["duracion"]=$movie->getDuracion();
            $valuesArray["idioma"]=$movie->getIdioma();
            $valuesArray["descripcion"]=$movie->getIdioma();
            $valuesArray["fecha"]=$movie->getIdioma();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/movie.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->movieList=array();
        //Si existe el archivo
        if(file_exists(dirname(__DIR__) ."/data/movie.json")){
            $jsonContent =file_get_contents(dirname(__DIR__) . "/data/movie.json");
            //Si tiene datos el archivo
            if ($jsonContent) {
                //Lo decodifica
                $arrayToDecode=json_decode($jsonContent,true);
            }
            foreach($arrayToDecode["results"] as $pelicula)
            {
                $movie = new Pelicula($pelicula["title"],null,$pelicula["original_language"],$pelicula["overview"],$pelicula["release_date"]);
                array_push($this->movieList, $movie);   
            }
        }else{
            //Sino llama a la API y le devuelve el JSON que se aloja en variable
            $variable = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
            if ($variable){
                //Si variable tiene datos, se decodifica
                $arrayToDecode = json_decode($variable,true);    
                foreach($arrayToDecode["results"] as $pelicula){
                    $movie = new Pelicula($pelicula["title"],null,$pelicula["original_language"],$pelicula["overview"],$pelicula["release_date"]);
                    array_push($this->movieList, $movie);   
                }
            }
        }  
        
    }

    public function getMovieList(){
        return $this->movieList;
    }
}


?>