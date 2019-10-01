<?php
namespace repository;

use repository\IRepository as IRepository;
use model\Pelicula as Pelicula;

class PeliRepository extends IRepository{
    private $movieList;

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

        foreach($this->cineList as $movie){
            $valuesArray["nombre"]=$movie->getNombre();
            $valuesArray["duracion"]=$movie->getDuracion();
            $valuesArray["idioma"]=$movie->getIdioma();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/movie.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->cineList=array();
        if(file_exists(dirname(__DIR__) ."data/movie.json")){
            $jsonContent =file_get_contents(dirname(__DIR__) . "data/movie.json");
            $arrayToDecode=($jsonContent) ? json_decode($jsonContent,true) :array();

            foreach($arrayToDecode as $valuesArray)
            {
                $movie = new Pelicula($valuesArray["nombre"], $valuesArray["duracion"],$valuesArray["idioma"]);
                array_push($this->movieList, $movie);
            }
        }
        
    }
}


?>