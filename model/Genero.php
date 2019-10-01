<?php
namespace model;

class Genero(){

    private $nombre;

    public function __construct($nombre){
        $this->nombre=$nombre;
    }
    
    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}

?>