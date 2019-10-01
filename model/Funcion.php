<?php
namespace model;

class Funcion{
    //Sera util asignarle un id ? 
    private $dia;
    private $hora;

    //Constructor
    public function __construct($dia,$hora){
        $this->dia=$dia;
        $this->hora=$hora;
    }

    //Getters
    public function getDia(){
        return $this->dia;
    }

    public function getHora(){
        return $this->hora;
    }

    //Setters
    public function setDia($dia){
        $this->dia = $dia;
    }

    public function setHora($hora){
        $this->hora = $hora;
    }
}


?>