<?php
namespace model;

class Pelicula{
    
    //Falta agregarle algunos atributos mas 
    //Aun no se que tipo de dato es una imagen aca, pero lo dejo creado por si en algun momento se va a usar
    //private $imagen;
    private $nombre;
    private $duracion;
    private $idioma;
    
    public function __construct($nombre,$duracion,$idioma){
        $this->nombre=$nombre;
        $this->duracion=$duracion;
        $this->idioma=$idioma;
    }

    //Getters
    public function getNombre(){
        return $this->nombre;
    }

    public function getDuracion(){
        return $this->duracion;
    }

    public function getIdioma(){
        return $this->idioma;
    }

    //Setters
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setDuracion($duracion){
        $this->duracion = $duracion;
    }

    public function setIdioma($idioma){
        $this->idioma = $idioma;
    }
    
}


?>