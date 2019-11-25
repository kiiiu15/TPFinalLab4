<?php namespace Model;

use \JsonSerializable as JsonSerializable;

class Room implements JsonSerializable {
    private $id;
    private $name;
    private $price; 
    private $capacity;
    private $cinema;

    public function __construct($id = 0, $name = "", $price = 0, $capacity = 0, $cinema = null){
        $this->id=$id;
        $this->name=$name;
        $this->price=$price;
        $this->capacity=$capacity;
        $this->cinema=$cinema;
    }


    //Getters
    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getPrice(){
        return $this->price;
    }
    public function getCapacity(){
        return $this->capacity;
    }

    public function getCinema(){
        return $this->cinema;
    }
    
    //setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function setCapacity($capacity){
        $this->capacity = $capacity;

    }

    public function setCinema($cinema){
        $this->cinema = $cinema;
    }

    public function jsonSerialize()
    {
        return array(
            "id" => $this->id ,
            "name" => $this->name ,
            "price" => $this->price ,
            "capacity" => $this->capacity ,
            "cinema" => $this->cinema 
        );
    }

}




?>