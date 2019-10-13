<?php
namespace Dao;

use Dao\IDao as IDao;
use Model\User as User;

class UserDao implements IDao{
    
    private $userList=array();

    public function GetAll()
    {
        $this->RetrieveData();
        return $this->userList;
    }

    public function Add($newUser)
    {
        $this->RetrieveData();
        array_push($this->userList,$newUser);
        $this->SaveData();
    }

    public function Delete($userEmail)
    {
        $this->RetrieveData();
        foreach($this->userList as $key =>$user){
            if($user->getEmail() == $userEmail){
                unset($this->userList[$key]);
                break;
            }
        }
        $this->SaveData();
    }

    public function SaveData()
    {
        $arrayToEncode =array();

        foreach($this->userList as $user){
            $valuesArray["email"]=$user->getEmail();
            $valuesArray["password"]=$user->getPassword();
            array_push($arrayToEncode,$valuesArray);
        }
        $jsonContent =json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents(dirname(__DIR__) . '/Data/Users.json',$jsonContent);
    }

    public function RetrieveData()
    {
        $this->userList=array();
        if(file_exists(dirname(__DIR__) ."/Data/Users.json")){
            $jsonContent =file_get_contents(dirname(__DIR__) . "Data/Users.json");
            $arrayToDecode=($jsonContent) ? json_decode($jsonContent,true) :array();

            foreach($arrayToDecode as $valuesArray)
            {
                $user = new User($valuesArray["email"], $valuesArray["password"]);

                array_push($this->userList, $user);
            }
        }
        
    }

    public function getByEmail($email) 
    {
        $this->RetrieveData();

        foreach ($this->userList as $key => $user) {
            if($user->getEmail() == $email) {
                return $user;
            }
        }
    }


}


?>