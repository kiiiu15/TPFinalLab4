<?php  
namespace model;

class Cine{
    
    //Atributos Cine, Posiblemente tengamos que agregar algun atributo mas 
    private $nombre;
    private $direccion;
    private $capacidad;
    private $valorEntrada;

    //Constructor
    public function __construct($nombre,$direccion,$capacidad,$valorEntrada){
        $this->nombre=$nombre;
        $this->direccion=$direccion;
        $this->capacidad=$capacidad;
        $this->valorEntrada=$valorEntrada;
    }
    
    //Getters
    public function getNombre(){
        return $this->nombre;
    }

    public function getDireccion(){
        return $this->direccion;
    }

    public function getCapacidad(){
        return $this->capacidad;
    }

    public function getValorEntrada(){
        return $this->valorEntrada;
    }

    //Setters
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function setCapacidad($capacidad){
        $this->capacidad = $capacidad;
    }
 
    public function setValorEntrada($valorEntrada){
        $this->valorEntrada = $valorEntrada;
    }

}

?>