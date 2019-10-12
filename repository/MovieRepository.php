<?php
namespace repository;
include_once("/config/autoload.php");
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

    /**
     * comprueba si ya existe una pelicula con ese titulo
     */
    public function checkMovie($title){
        $ans = false;
        foreach ($this->movieList as $movie) {
            if($movie->getTitle() == $title)
            {
                $ans = true;
            }
        }
        return $ans;
    }

    public function retrieveApi($arrayToEncode){
        $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
            
            if ($apiContent){
                //Si apiContent tiene datos, se decodifica
                $arrayToDecode  = json_decode($apiContent,true);    

                //$arrayToEncode = array();

                foreach ($arrayToDecode["results"] as $movie) {

                    if(!$this->checkMovie($movie["title"]))
                    {
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
                }

                //creamos el json con toda la info de la api
                $newjsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
                file_put_contents(dirname(__DIR__) . '/data/movie.json',$newjsonContent);
            }
    }

    public function RetrieveData(){
        $this->movieList = array();
        $arrayToEncode = array();
        //Si existe el archivo
        if(file_exists(dirname(__DIR__) ."/data/movie.json")){
            $jsonContent = file_get_contents(dirname(__DIR__) . "/data/movie.json");
            //Si tiene datos el archivo
            if ($jsonContent) {
                //Lo decodifica
                $arrayToDecode = json_decode($jsonContent,true);

                foreach($arrayToDecode as $movie)
                {  
                    $valuesArray = array();
                    $valuesArray["title"]               =  $movie["title"];
                    $valuesArray["original_language"]   =  $movie["original_language"];
                    $valuesArray["overview"]            =  $movie["overview"];
                    $valuesArray["release_date"]        =  $movie["release_date"];
                    $valuesArray["poster_path"]         =  $movie["poster_path"];

                    $newMovie = new Movie($movie["title"],$movie["original_language"],$movie["overview"],$movie["release_date"],$movie["poster_path"]);
                    array_push($this->movieList, $newMovie);   

                    array_push($arrayToEncode,$valuesArray);
                }
                $this->retrieveApi($arrayToEncode);
            } else {//si el archivo existe pero esta vacio se trae todo la info de la api
                $this->retrieveApi($arrayToEncode);
            }
            
        }else{
            //Sino llama a la API y le devuelve el JSON
            $this->retrieveApi($arrayToEncode);
        }  
    }

    /*public function updateJson(){
        $this->RetrieveData();

        $arrayToEncode = array();

        $jsonContent = file_get_contents(dirname(__DIR__) . "/data/movie.json");

        $arrayToDecode = json_decode($jsonContent,true);

        foreach ($arrayToDecode as $movie) {
            array_push($arrayToEncode,$movie);    
        }
        
        $apiContent = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
        
        if($apiContent){
            $arrayToDecode = json_decode($apiContent,true);

            foreach ($arrayToDecode["results"] as $movie) {

                $valuesArray = array();
                $valuesArray["title"]               =  $movie["title"];
                $valuesArray["original_language"]   =  $movie["original_language"];
                $valuesArray["overview"]            =  $movie["overview"];
                $valuesArray["release_date"]        =  $movie["release_date"];
                $valuesArray["poster_path"]         =  $movie["poster_path"];

                array_push($arrayToEncode,$valuesArray);
            }
        }
        $newjsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/movie.json',$newjsonContent);
    }*/

}


?>