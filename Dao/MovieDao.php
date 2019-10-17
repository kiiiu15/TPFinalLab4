<?php

namespace Dao;

use Dao\IDao as IDao;
use Model\Movie as Movie;

class MovieDao implements IDao
{
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

    /**
     * busca el titulo de la pelicula y lo saca de la lista
     */
    public function Remove($movieTitle){
        $this->RetrieveData();
        foreach($this->movieList as $key =>$movie){
            if($movie->getNombre() == $movieTitle){
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
            $valuesArray["title"]             = $movie->getTitle();
            $valuesArray["original_language"] = $movie->getLanguage();
            $valuesArray["overview"]          = $movie->getOverview();
            $valuesArray["release_date"]      = $movie->getReleaseDate();
            $valuesArray["poster_path"]       = $movie->getPoster();
            $valuesArray["genre_ids"]         =$movie->getGenre_ids();
            
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

    public function retrieveApi()
    {
        $arrayToEncode=array();
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
                        $valuesArray["genre_ids"]         =  $movie["genre_ids"];

                        $movie = new Movie($movie["title"],$movie["original_language"],$movie["overview"],$movie["release_date"],$movie["poster_path"],$movie["genre_ids"]);
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
                    $valuesArray["genre_ids"]         =  $movie["genre_ids"];


                    $newMovie = new Movie($movie["title"],$movie["original_language"],$movie["overview"],$movie["release_date"],$movie["poster_path"],$movie["genre_ids"]);

                    array_push($this->movieList, $newMovie);   
                    array_push($arrayToEncode,$valuesArray);
                }
                
            } else {//si el archivo existe pero esta vacio se trae todo la info de la api
                $this->retrieveApi();
            }
            
        }else{
            //Sino llama a la API y le devuelve el JSON
            $this->retrieveApi();
        }  
    }

    public function getMovieForGenre($idGenreToSearch){
        $this->RetrieveData();
        $listMovieGenre=array();
        foreach($this->movieList as $key=>$movie){
            if($movie->getGenre_ids() == $idGenreToSearch){
                array_push($listMovieGenre,$movie);
            }
        }
        return $listMovieGenre;
    }
}

?>