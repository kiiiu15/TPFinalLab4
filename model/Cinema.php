<?php  
namespace Model;

use \JsonSerializable as JsonSerializable;

class Cinema implements JsonSerializable {
    
    //Atributos cine, Posiblemente tengamos que agregar algun atributo mas 
    private $idCinema;
    private $name;
    private $Address;
    private $active;

    //Constructor
    public function __construct($idCinema ="",$name="",$Address="",$active=true){
        $this->setIdCinema($idCinema);
        $this->setName($name);
        $this->setAddress($Address);
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

    
    public function setIdCinema($idCinema){
        $this->idCinema = $idCinema;
    }
    
    public function setActive($active){
        $this->active = $active;
    }

    public function jsonSerialize()
    {
        return array(
            "idCinema" => $this->idCinema ,
            "name" => $this->name ,
            "Address" => $this->Address ,
            "active" => $this->active 
        );
    }
}

?>