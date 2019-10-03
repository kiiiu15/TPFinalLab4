<?php
namespace repository;
use repository\IRepository as IRepository;
use model\Usuario as Usuario;

class UserRepository implements IRepository{
    
    private $userList=array();

    public function GetAll(){
        $this->RetrieveData();
        return $this->userList;
    }

    public function Add($value){
        $this->RetrieveData();
        array_push($this->userList,$value);
        $this->SaveData();
    }

    public function Delete($value){
        $this->RetrieveData();
        foreach($this->userList as $key =>$user){
            if($user->getEmail() == $value){
                unset($this->userList[$key]);
                break;
            }
        }
        $this->SaveData();
    }

    public function SaveData(){
        $arrayToEncode =array();

        foreach($this->userList as $user){
            $valuesArray["email"]=$user->getEmail();
            $valuesArray["contraseña"]=$user->getContraseña();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/data/users.json',$jsonContent);
    }

    public function RetrieveData(){
        $this->userList=array();
        if(file_exists(dirname(__DIR__) ."data/users.json")){
            $jsonContent =file_get_contents(dirname(__DIR__) . "data/users.json");
            $arrayToDecode=($jsonContent) ? json_decode($jsonContent,true) :array();

            foreach($arrayToDecode as $valuesArray)
            {
                $user = new Usuario($valuesArray["email"], $valuesArray["contraseña"]);

                array_push($this->userList, $user);
            }
        }
        
    }

    public function getByEmail($email) {
        $this->RetrieveData();

        foreach ($this->userList as $key => $user) {
            if($user->getEmail() == $email) {
                return $user;
            }
        }
    }


}


?>