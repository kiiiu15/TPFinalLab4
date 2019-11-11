<?php
namespace Model;

class Ticket{
    
    private $idTicket;
    private $QR;
    private $Buy;
    //Aca pondriamos el QR y aun no se si ponerle el id de la compra

    public function __construct($idTicket = 0,$QR = "",$Buy = null){
        $this->idTicket=$idTicket;
        $this->QR=$QR;
        $this->Buy = $Buy;
    }

    
    //Getters y Setters

    public function getIdTicket(){
        return $this->idTicket;
    }

    public function getQR(){
        return $this->QR;
    }
    
    public function getBuy()
    {
        return $this->idBuy;
    }

    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
    }

    public function setQR($QR){
        $this->QR = $QR;
    }

    public function setBuy($Buy)
    {
        $this->Buy = $Buy;

        return $this;
    }
}

?>