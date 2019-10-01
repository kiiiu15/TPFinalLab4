<?php
namespace model;

class PagoTC{
    private $fecha;
    private $idAutorizacion;
    private $total;

    //Constructor
    public function __construct($fecha,$idAutorizacion,$total){
        $this->fecha=$fecha;
        $this->idAutorizacion=$idAutorizacion;
        $this->total=$total;       
    }

    //Getters
    public function getFecha(){
        return $this->fecha;
    }

    public function getIdAutorizacion(){
        return $this->idAutorizacion;
    }

    public function getTotal(){
        return $this->total;
    }

    //Setters
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setIdAutorizacion($idAutorizacion){
        $this->idAutorizacion = $idAutorizacion;
    }

    public function setTotal($total){
        $this->total = $total;
    }

    
}


?>