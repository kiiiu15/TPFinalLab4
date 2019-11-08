<?php
namespace Model;

class CreditCardPayment{
    private $date; 
    private $idAuthorization;
    private $total;

    //Constructor
    public function __construct($date,$idAuthorization,$total){
        $this->date=$date;
        $this->idAuthorization=$idAuthorization;
        $this->total=$total;       
    }

    //Getters
    public function getDate(){
        return $this->date;
    }

    public function getIdAuthorization(){
        return $this->idAuthorization;
    }

    public function getTotal(){
        return $this->total;
    }

    //Setters
    public function setDate($date){
        $this->date = $date;
    }

    public function setIdAuthorization($idAuthorization){
        $this->idAuthorization = $idAuthorization;
    }

    public function setTotal($total){
        $this->total = $total;
    }

    
}


?>