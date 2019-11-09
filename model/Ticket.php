<?php
namespace Model;

class Ticket{
    
    private $idTicket;
    private $QR;
    private $idBuy;
    //Aca pondriamos el QR y aun no se si ponerle el id de la compra

    public function __construct($idTicket,$QR,$idBuy){
        $this->idTicket=$idTicket;
        $this->QR=$QR;
        $this->idBuy = $idBuy;
    }

    
    //Getters y Setters

    public function getIdTicket(){
        return $this->idTicket;
    }

    public function getQR(){
        return $this->QR;
    }
    
    public function getIdBuy()
    {
        return $this->idBuy;
    }

    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
    }

    public function setQR($QR){
        $this->QR = $QR;
    }

    public function setIdBuy($idBuy)
    {
        $this->idBuy = $idBuy;

        return $this;
    }
}

?>