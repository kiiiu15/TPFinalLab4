<?php  
namespace model;

class Cinema{
    
    //Atributos cine, Posiblemente tengamos que agregar algun atributo mas 
    private $idCinema;
    private $name;
    private $Address;
    private $capacity;
    private $price;

    //Constructor
    public function __construct($idCinema,$name,$Address,$capacity,$price){
        $this->idCinema=$idCinema;
        $this->name=$name;
        $this->Address=$Address;
        $this->capacity=$capacity;
        $this->price=$price;
    }

    //Getters
    
    public function getIdCinema(){
        return $this->idCinema;
    }
    
    public function getName(){
        return $this->name;
    }

    public function getAddress(){
        return $this->Address;
    }

    public function getCapacity(){
        return $this->capacity;
    }

    public function getPrice(){
        return $this->price;
    }

    //Setters
    public function setName($name){
        $this->name = $name;
    }

    public function setAddress($Address){
        $this->Address = $Address;
    }

    public function setCapacity($capacity){
        $this->capacity = $capacity;
    }
 
    public function setPrice($price){
        $this->price = $price;
    }
    
    public function setIdCinema($idCinema){
        $this->idCinema = $idCinema;
    }
    
}

?>