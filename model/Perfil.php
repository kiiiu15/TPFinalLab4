<?php
namespace model;

class Perfil{
    
    private $nombre;
    private $apellido;
    private $dni;
    private $numeroTelefono;
    //Comento el atributo tarjeta de credito, por el momento no se va a utilizar
    //private $tarjetaCredito;

    //Constructor
    public function __construct($nombre,$apellido,$dni,$numeroTelefono){
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->dni=$dni;
        $this->numeroTelefono=$numeroTelefono;
    }

    //Getters
    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getDni(){
        return $this->dni;
    }

    public function getNumeroTelefono(){
        return $this->numeroTelefono;
    }

    //Setters

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function setDni($dni){
        $this->dni = $dni;
    }

    public function setNumeroTelefono($numeroTelefono){
        $this->numeroTelefono = $numeroTelefono;
    }
    
}



?>