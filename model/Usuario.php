<?php
namespace model;

class Usuario{

    private $email;
    private $contraseña;

    //Constructor
    public function __construct($email,$contraseña){
        $this->email=$email;
        $this->contraseña=$contraseña;
    }

    //Getters
    public function getEmail(){
        return $this->email;
    }
 
    public function getContraseña(){
        return $this->contraseña;
    }

    //Setters
    public function setEmail($email){
        $this->email = $email;
    }

    public function setContraseña($contraseña){
        $this->contraseña = $contraseña;
    }
}

?>