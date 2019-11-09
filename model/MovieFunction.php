<?php
namespace Model;



class MovieFunction{

    private $id;
    private $day; 
    private $hour;
    private $cinema;
    private $room;
    private $movie;

    //Constructor
    public function __construct($id = 0,$day = '',$hour = '',$cinema = null,$room = null,$movie = null){
        $this->id=$id;
        $this->day=$day;
        $this->hour=$hour;
        $this->cinema=$cinema;
        $this->room = $room;
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
    
    public function getRoom()
    {
        return $this->room;
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

    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }
}


?>