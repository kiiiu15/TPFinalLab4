<?php
namespace Model;



class MovieFunction{
    //Sera util asignarle un id ? 
    // ID, PELICULA (REFERENCIA) Y CINE (REFERENCIA)
    private $id;
    private $day;
    private $hour;
    private $cinema;
    private $movie;

    //Constructor
    public function __construct($id,$day,$hour,$cinema,$movie){
        $this->id=$id;
        $this->day=$day;
        $this->hour=$hour;
        $this->cinema=$cinema;
        $this->movie=$movie;
    }

    //Getters
    public function getDay(){
        return $this->day;
    }

    public function getHour(){
        return $this->hour;
    }

    public function getId(){
        return $this->id;
    }
    
    public function getCinema(){
        return $this->cinema;
    }
    
    public function getMovie(){
        return $this->movie;
    }
    
    //Setters
    public function setDay($day){
        $this->day = $day;
    }

    public function setHour($hour){
        $this->hour = $hour;
    }

    public function setId($id){
        $this->id = $id;
    }  

    public function setCinema($cinema){
        $this->cinema = $cinema;
    }

    public function setMovie($movie){
        $this->movie = $movie;
    }
}


?>