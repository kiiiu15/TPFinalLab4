<?php
namespace model;

class MovieFunction{
    //Sera util asignarle un id ? 
    private $day;
    private $hour;

    //Constructor
    public function __construct($day,$hour){
        $this->day=$day;
        $this->hour=$hour;
    }

    //Getters
    public function getDay(){
        return $this->day;
    }

    public function getHour(){
        return $this->hour;
    }

    //Setters
    public function setDay($day){
        $this->day = $day;
    }

    public function setHour($hour){
        $this->hour = $hour;
    }
}


?>