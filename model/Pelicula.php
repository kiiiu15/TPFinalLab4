<?php
namespace model;

class Pelicula{
    
    //Falta agregarle algunos atributos mas 
    //Aun no se que tipo de dato es una imagen aca, pero lo dejo creado por si en algun momento se va a usar
    //private $imagen;
    private $nombre;
    private $idioma;
    private $descripcion;
    private $fechaEstreno;
    private $poster;

    public function __construct($nombre = "",$idioma ="",$descripcion="",$fechaEstreno="",$poster=""){
        $this->nombre=$nombre;
        $this->idioma=$idioma;
        $this->descripcion=$descripcion;
        $this->fechaEstreno=$fechaEstreno;
        $this->poster= "https://image.tmdb.org/t/p/w200/" . $poster;
    }

    //Getters
    public function getNombre(){
        return $this->nombre;
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

    public function getPoster(){
        return $this->poster;
    }
    
    //Setters
    public function setNombre($nombre){
        $this->nombre = $nombre;
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

    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }
}


?>