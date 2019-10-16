<?php
namespace Model;

class Genre{

    private $idApi;
    private $name;

    public function __construct($idApi=0,$name=""){
        $this->setIdApi($idApi);
        $this->setName($name);
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
        if($idApi == 0){
            $this->idApi = 1;

        }else{
            $this->idApi = $idApi;
        }
    }
}

?>