<?php
namespace Model;

class Buy{
    
    private $idBuy;
    private $date;
    private $numberOfTickets;
    private $total;
    private $discount;

    //Constructor
    public function __construct($idBuy,$date,$numberOfTickets,$total,$discount){
        $this->idBuy=$idBuy;
        $this->date=$date;       
        $this->numberOfTickets=$numberOfTickets;
        $this->total=$total;
        $this->discount=$discount;
    }

    //Getters
    public function getIdBuy(){
        return $this->idBuy;
    }
    
    public function getDate(){
        return $this->date;
    }

    public function getNumberOfTickets(){
        return $this->numberOfTickets;
    }

    public function getTotal(){
        return $this->total;
    }

    public function getDiscount(){
        return $this->discount;
    }

    //Setters
    public function setIdBuy($idBuy){
        $this->idbuy = $idBuy;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function setNumberOfTickets($numberOfTickets){
        $this->numberOfTickets = $numberOfTickets;
    }

    public function setTotal($total){
        $this->total = $total;
    }

    public function setDiscount($discount){
        $this->discount = $discount;
    }
}


?>