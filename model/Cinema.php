<?php  
namespace Model;

class Cinema{
    
    //Atributos cine, Posiblemente tengamos que agregar algun atributo mas 
    private $idCinema;
    private $name;
    private $Address;
    private $capacity;
    private $price;
    private $active;

    //Constructor
    public function __construct($idCinema ="",$name="",$Address="",$capacity="",$price="",$active=false){
        $this->setIdCinema($idCinema);
        $this->setName($name);
        $this->setAddress($Address);
        $this->setCapacity($capacity);
        $this->setPrice($price);
        $this->setActive($active);
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
    
    public function getActive(){
        return $this->active;
    }

    //Setters
    public function setName($name){
        $this->name = $name;
    }

    public function setAddress($Address){
        $this->Address = $Address;
    }

    public function setCapacity($capacity){
        if ($capacity > 0){
            $this->capacity = $capacity;
        }else{
            $this->capacity = 1;
        }
        
    }
 
    public function setPrice($price){
        if ($price > 0){
            $this->price = $price;
        } else {
            $this->price = 1;
        }
        
    }
    
    public function setIdCinema($idCinema){
        $this->idCinema = $idCinema;
    }
    
    public function setActive($active){
        $this->active = $active;
    }
}

?>