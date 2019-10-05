<?php
namespace model;

class Movie{
    
    private $Name;
    private $Language;
    private $Description;
    private $ReleaseDate;
    private $Poster;//la imagen de la pelicula
    //$Poster es un string con la direccion de donde este alojado la imagen o Poster de la
    //pelicula, ya sea desde internet, o carpeta local

    public function __construct($Name = "",$Language ="",$Description="",$ReleaseDate="",$Poster=""){
        $this->Name=$Name;
        $this->Language=$Language;
        $this->Description=$Description;
        $this->ReleaseDate=$ReleaseDate;
        $this->Poster= "https://image.tmdb.org/t/p/w200/" . $Poster;
    }

    //Getters
    public function getName(){
        return $this->Name;
    }

    public function getLanguage(){
        return $this->Language;
    }
    
    public function getDescription(){
        return $this->Description;
    }

    public function getReleaseDate(){
        return $this->ReleaseDate;
    }

    public function getPoster(){
        return $this->Poster;
    }
    
    //Setters
    public function setName($Name){
        $this->Name = $Name;
    }

    public function setLanguage($Language){
        $this->Language = $Language;
    }
    
    public function setReleaseDate($ReleaseDate){
        $this->ReleaseDate = $ReleaseDate;
    }
    
    public function setDescription($Description){
        $this->Description = $Description;
    }

    public function setPoster($Poster)
    {
        $this->Poster = $Poster;

        return $this;
    }
}


?>