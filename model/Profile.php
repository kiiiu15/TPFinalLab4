<?php
namespace Model;

class Profile{
    
   // private $id;//no se si esto esta bien 
    private $Name;
    private $LastName;
    private $Dni;
    private $TelephoneNumber;
    //Comento el atributo tarjeta de credito, por el momento no se va a utilizar
    //private $CreditCard;

    //Constructor
    public function __construct(/*$id,*/$Name,$LastName,$Dni,$TelephoneNumber){
        //$this->id = $id;
        $this->Name=$Name;
        $this->LastName=$LastName;
        $this->Dni=$Dni;
        $this->TelephoneNumber=$TelephoneNumber;
    }

    //Getters
    public function getName(){
        return $this->Name;
    }

    public function getLastName(){
        return $this->LastName;
    }

    public function getDni(){
        return $this->Dni;
    }

    public function getTelephoneNumber(){
        return $this->TelephoneNumber;
    }

    //Setters

    public function setName($Name){
        $this->Name = $Name;
    }

    public function setLastName($LastName){
        $this->LastName = $LastName;
    }

    public function setDni($Dni){
        $this->Dni = $Dni;
    }

    public function setTelephoneNumber($TelephoneNumber){
        $this->TelephoneNumber = $TelephoneNumber;
    }
    



    //los dejo aca asi por q no se si estan bien que tenga id el propio objeto
    /**
     * Get the value of id
     */ 
    /*public function getId()
    {
        return $this->id;
    }*/

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    /*public function setId($id)
    {
        $this->id = $id;

        return $this;
    }*/
}



?>