<?php
namespace Model;

class User{

    private $Email;
    private $Password;

    //Constructor
    public function __construct($Email,$Password){
        $this->Email=$Email;
        $this->Password=$Password;
    }

    //Getters
    public function getEmail(){
        return $this->Email;
    }
 
    public function getPassword(){
        return $this->Password;
    }

    //Setters
    public function setEmail($Email){
        $this->Email = $Email;
    }

    public function setPassword($Password){
        $this->Password = $Password;
    }
}

?>