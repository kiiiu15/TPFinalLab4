<?php
namespace model;

class CtaCredito{
    private $empresa;

    public function __construct($empresa){
        $this->empresa=$empresa;
    }

    //Getters y Setters
    public function getEmpresa(){
        return $this->empresa;
    }

    public function setEmpresa($empresa){
        $this->empresa = $empresa;
    }
}


?>