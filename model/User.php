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
    public function GetEmail(){
        return $this->Email;
    }
 
    public function GetPass(){
        return $this->Pass;
    }

    public function GetRole()
    {
        return $this->role;
    }

    public function GetProfile()
    {
        return $this->profile;
    }

    //Setters
    public function SetEmail($Email){
        $this->Email = $Email;
    }

    public function SetPass($Pass){
        $this->Pass = $Pass;
    }

    public function SetProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    public function SetRole($role)
    {
        $this->role = $role;

        return $this;
    }
}

?>