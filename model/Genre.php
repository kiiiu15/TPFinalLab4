<?php
namespace Model;

class Genre{

    private $idApi;
    private $name;

    public function __construct($idApi,$name){
        $this->idApi=$idApi;
        $this->name=$name;
    }
    
    //Getters
    public function getIdApi(){
        return $this->idApi;
    }

    public function getName(){
        return $this->name;
    }


    //Setters
    public function setName($name){
        $this->name = $name;
    }

    public function setIdApi($idApi){
        $this->idApi = $idApi;
    }
}

?>