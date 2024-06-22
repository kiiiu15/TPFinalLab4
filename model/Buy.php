<?php
namespace Model;

class Buy{
    
    private $idBuy; 
    private $MovieFunction; 
    private $date;
    private $numberOfTickets;
    private $total;
    private $discount;
    private $user;
    private $state;

    //Constructor
    public function __construct($idBuy = 0,$MovieFunction = null,$date = "",$numberOfTickets = 0,$total = 0 ,$discount = 0  ,$user = null,$state = ""){
        $this->idBuy=$idBuy;
        $this->MovieFunction = $MovieFunction;
        $this->date=$date;       
        $this->numberOfTickets=$numberOfTickets;
        $this->total=$total;
        $this->discount=$discount;
        $this->user=$user;
        $this->state=$state;
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

    public function getUser(){
        return $this->user;
    }

    public function getState(){
        return $this->state;
    }

    //Setters
    public function setIdBuy($idBuy){
        $this->idBuy = $idBuy;
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

    public function setUser($user){
        $this->user = $user;
    }

    public function setState($state){
        $this->state = $state;
    }

    /**
     * Get the value of MovieFunction
     */ 
    public function getMovieFunction()
    {
        return $this->MovieFunction;
    }

    /**
     * Set the value of MovieFunction
     *
     * @return  self
     */ 
    public function setMovieFunction($MovieFunction)
    {
        $this->MovieFunction = $MovieFunction;

        return $this;
    }
}


?>