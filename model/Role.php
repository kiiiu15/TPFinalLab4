<?php
namespace model;

class Role{
    private $RoleName;

    //Constructor
    public function __construct($RoleName){
        $this->RoleName=$RoleName;
    }

    //Getters y Setters
    public function getRoleName(){
        return $this->RoleName;
    }

    public function setRoleName($RoleName){
        $this->RoleName = $RoleName;
    }
}

?>