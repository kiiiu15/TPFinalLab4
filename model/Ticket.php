<?php
namespace Model;

class Ticket{
    
    private $idTicket;
    private $QR;
    //Aca pondriamos el QR y aun no se si ponerle el id de la compra

    public function __construct($idTicket,$QR){
        $this->idTicket=$idTicket;
        $this->QR=$QR;
    }

    
    //Getters y Setters

    public function getIdTicket(){
        return $this->idTicket;
    }

    public function getQR(){
        return $this->QR;
    }

    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
    }

    public function setQR($QR){
        $this->QR = $QR;
    }
}

?>