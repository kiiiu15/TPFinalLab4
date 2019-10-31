<?php
namespace Model;

class User{

    private $Email;
    private $Pass;
    private $profile;
    private $role;

    //Constructor
    public function __construct($Email,$Pass,$role,$profile){
        $this->Email=$Email;
        $this->Pass=$Pass;
        $this->role = $role;
        $this->profile = $profile;
    }

    //Getters
    public function getEmail(){
        return $this->Email;
    }
 
    public function getPass(){
        return $this->Pass;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    //Setters
    public function setEmail($Email){
        $this->Email = $Email;
    }

    public function setPass($Pass){
        $this->Pass = $Pass;
    }

    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}

?>