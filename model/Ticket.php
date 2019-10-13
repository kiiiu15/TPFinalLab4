<?php
namespace Model;

class Ticket{
    
    private $idTicket;
    //Aca pondriamos el QR y aun no se si ponerle el id de la compra

    public function __construct($idTicket){
        $this->idTicket=$idTicket;
    }

    
    //Getters y Setters

    public function getIdTicket(){
        return $this->idTicket;
    }

    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
    }
}

?>