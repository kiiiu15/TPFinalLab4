<?php
namespace Model;
use \JsonSerializable as JsonSerializable;

class Genre implements JsonSerializable{

    private $id;
    private $name;

    public function __construct($id=0,$name=""){
        $this->setid($id);
        $this->setName($name);
    }
    
    //Getters
    public function getid(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }


    //Setters
    public function setName($name){
        $this->name = $name;
    }

    public function setid($id){
        if($id == 0){
            $this->id = 1;

        }else{
            $this->id = $id;
        }
    }

    public function jsonSerialize()
    {
        return array(
            "id" => $this->id ,
            "name" => $this->name 
        );
    }
}

?>