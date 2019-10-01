<?php
namespace model;

class Rol{
    private $nombre;

    //Constructor
    public function __construct($nombre){
        $this->nombre=$nombre;
    }

    //Getters y Setters
    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
}

?>