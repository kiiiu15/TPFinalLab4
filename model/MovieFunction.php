<?php
namespace Model;

use \JsonSerializable as JsonSerializable;



class MovieFunction implements JsonSerializable{

    private $id;
    private $day; 
    private $hour;
    private $room;
    private $movie;

    //Constructor
    public function __construct($id = 0,$day = '',$hour = '',$room = null,$movie = null){
        $this->id=$id;
        $this->day=$day;
        $this->hour=$hour;
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

   
    public function setMovie($movie){
        $this->movie = $movie;
    }

    public function setRoom($room)
    {
        $this->room = $room;

        return $this;
    }


    public function jsonSerialize()
    {
        return array(
            "id" => $this->id ,
            "day" => $this->day ,
            "hour" => $this->hour ,
            "room" => $this->room ,
            "movie" => $this->movie
        );
    }
    
}


?>