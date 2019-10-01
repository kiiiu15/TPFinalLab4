<?php
namespace model;

class Compra{
    
    private $idCompra;
    private $fecha;
    private $cantidadEntradas;
    private $total;
    private $descuento;

    //Constructor
    public function __construct($idCompra,$fecha,$cantidadEntradas,$total,$descuento){
        $this->idCompra=$idCompra;
        $this->fecha=$fecha;       
        $this->cantidadEntradas=$cantidadEntradas;
        $this->total=$total;
        $this->descuento=$descuento;
    }

    //Getters
    public function getIdCompra(){
        return $this->idCompra;
    }
    
    public function getFecha(){
        return $this->fecha;
    }

    public function getCantidadEntradas(){
        return $this->cantidadEntradas;
    }

    public function getTotal(){
        return $this->total;
    }

    public function getDescuento(){
        return $this->descuento;
    }

    //Setters
    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setCantidadEntradas($cantidadEntradas){
        $this->cantidadEntradas = $cantidadEntradas;
    }

    public function setTotal($total){
        $this->total = $total;
    }

    public function setDescuento($descuento){
        $this->descuento = $descuento;
    }
}


?>