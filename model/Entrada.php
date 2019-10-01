<?php
namespace model;

class Entrada{
    
    private $idEntrada;
    //Aca pondriamos el QR y aun no se si ponerle el id de la compra

    public function __construct($idEntrada){
        $this->idEntrada=$idEntrada;
    }

    
    //Getters y Setters

    public function getIdEntrada(){
        return $this->idEntrada;
    }

    public function setIdEntrada($idEntrada){
        $this->idEntrada = $idEntrada;
    }
}

?>