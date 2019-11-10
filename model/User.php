<?php
namespace Model;

class User{

    private $id;
    private $Email;
    private $Pass;
    private $profile;
    private $role;
    private $creditCards;

    //Constructor
    public function __construct($id,$Email="",$Pass="",$role = null,$profile = null,$creditCards = array()){
        $this->id=$id;
        $this->Email=$Email;
        $this->Pass=$Pass;
        $this->role = $role;
        $this->profile = $profile;
        $this->creditCards = $creditCards;
    }

    //Getters

    public function getId(){
        return $this->id;
    }

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

    public function getCreditCards(){
        return $this->creditCards;
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

    public function setId($id){
        $this->id = $id;
    }

 
    public function setCreditCards($creditCards){
        $this->creditCards = $creditCards;
    }
}

?>