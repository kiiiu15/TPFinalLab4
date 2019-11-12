<?php
namespace Model;

class CreditCard{
    private $company;
    private $number;
    private $segurityCode;
    private $expiryMonth;
    private $expiryYear;
    
    public function __construct($company = "", $number = 0, $segurityCode = 0,$expiryMonth = "",$expiryYear = ""){
        $this->company=$company;
        $this->number=$number;
        $this->segurityCode=$segurityCode;
        $this->expiryMonth = $expiryMonth;
        $this->expiryYear = $expiryYear;
    }

    //GETERS
    public function getCompany()
    {
        return $this->company;
    }

    public function getNumber()
    {
        return $this->number;
    }
    
    public function getSegurityCode()
    {
        return $this->segurityCode;
    }

    public function getExpiryMonth()
    {
        return $this->expiryMonth;
    }
    
    public function getExpiryYear()
    {
        return $this->expiryYear;
    }

    //SETTERS
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function setSegurityCode($segurityCode)
    {
        $this->segurityCode = $segurityCode;

        return $this;
    }
 
    public function setExpiryMonth($expiryMonth)
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    public function setExpiryYear($expiryYear)
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }
}


?>