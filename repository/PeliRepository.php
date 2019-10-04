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


    public function traerApi(){
        $variable = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
            
            if ($variable){
                //Si variable tiene datos, se decodifica
                $arrayToDecode  = json_decode($variable,true);    

                $arrayToEncode =array();

                foreach ($arrayToDecode["results"] as $peli) {
                    $valuesArray = array();
                    $valuesArray["title"]               =  $peli["title"];
                    $valuesArray["original_language"]   =  $peli["original_language"];
                    $valuesArray["overview"]            =  $peli["overview"];
                    $valuesArray["release_date"]        =  $peli["release_date"];
                    $valuesArray["poster_path"]         =  $peli["poster_path"];

                    $movie = new Pelicula($peli["title"],$peli["original_language"],$peli["overview"],$peli["release_date"],$peli["poster_path"]);
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

                foreach($arrayToDecode as $pelicula)
                {
                    $movie = new Pelicula($pelicula["title"],null,$pelicula["original_language"],$pelicula["overview"],$pelicula["release_date"],$pelicula["poster_path"]);
                    array_push($this->movieList, $movie);   
                }
            }
            else {
                $this->traerApi();
            }
            
        }else{
            //Sino llama a la API y le devuelve el JSON que se aloja en variable
            $this->traerApi();
        }  
    }

    public function getMovieList(){
        return $this->movieList;
    }


}


?>