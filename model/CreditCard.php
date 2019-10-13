<?php
namespace Model;

class CreditCard{
    private $company;

    public function __construct($company){
        $this->company=$company;
    }

    //Getters y Setters
    public function getCompany(){
        return $this->company;
    }

    public function setCompany($company){
        $this->company = $company;
    }
}


?>