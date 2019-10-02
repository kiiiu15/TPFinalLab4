<?php
namespace model;

class Pelicula{
    
    //Falta agregarle algunos atributos mas 
    //Aun no se que tipo de dato es una imagen aca, pero lo dejo creado por si en algun momento se va a usar
    //private $imagen;
    private $nombre;
    private $duracion;
    private $idioma;
    //
    private $descripcion;
    private $fechaEstreno;

    public function __construct($nombre = "",$duracion ="",$idioma ="",$descripcion="",$fechaEstreno=""){
        $this->nombre=$nombre;
        $this->duracion=$duracion;
        $this->idioma=$idioma;
        $this->descripcion=$descripcion;
        $this->fechaEstreno=$fechaEstreno;
    
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
    
    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getFechaEstreno(){
        return $this->fechaEstreno;
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
    
    public function setFechaEstreno($fechaEstreno){
        $this->fechaEstreno = $fechaEstreno;
    }
    
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }


   
}


?>