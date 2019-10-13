<?php
namespace Model;

class Movie{
    
    private $title;
    private $Language;
    private $overview;
    private $ReleaseDate;
    private $Poster;//la imagen de la pelicula
    //$Poster es un string con la direccion de donde este alojado la imagen o Poster de la
    //pelicula, ya sea desde internet, o carpeta local


    /*
    * usar el constructor solo en caso de traer las peliculas por la api
    * ya que poster se carga con la url de donde busca los posters la api
    * si se quiere usar un poster local sera necesario hacer un setPoster()
    */
    public function __construct($title = "",$Language ="",$overview="",$ReleaseDate="",$Poster=""){
        $this->title=$title;
        $this->Language=$Language;
        $this->overview=$overview;
        $this->ReleaseDate=$ReleaseDate;
        $this->Poster= "https://image.tmdb.org/t/p/w200" . $Poster;
    }

    //Getters
    public function getTitle(){
        return $this->title;
    }

    public function getLanguage(){
        return $this->Language;
    }
    
    public function getOverview(){
        return $this->overview;
    }

    public function getReleaseDate(){
        return $this->ReleaseDate;
    }

    public function getPoster(){
        return $this->Poster;
    }
    
    //Setters
    public function setTitle($title){
        $this->title = $title;
    }

    public function setLanguage($Language){
        $this->Language = $Language;
    }
    
    public function setReleaseDate($ReleaseDate){
        $this->ReleaseDate = $ReleaseDate;
    }
    
    public function setOverview($overview){
        $this->overview = $overview;
    }

    public function setPoster($Poster)
    {
        $this->Poster = $Poster;

        return $this;
    }
}


?>