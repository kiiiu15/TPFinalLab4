<?php
namespace Model;

class CreditCard{
    private $company;
    private $number;
    private $segurityCode;
    
    public function __construct($company = "", $number = 0, $segurityCode = 0){
        $this->company=$company;
        $this->number=$number;
        $this->segurityCode=$segurityCode;
    }

    //Getters y Setters
    public function getCompany(){
        return $this->company;
    }

    public function getNumber(){
        return $this->number;
    }
    
    public function getSegurityCode(){
        return $this->segurityCode;
    }

    public function setCompany($company){
        $this->company = $company;
    }

    public function setCompany($number){
        $this->number=$number;
    }

    public function setCompany($segurityCode){
        $this->segurityCode=$segurityCode;
    }

    
}


?>