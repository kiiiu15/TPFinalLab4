<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use model\CreditCard as CreditCard;
use Dao\CreditCardDB as CreditCardDB;


use controllers\UserController as UserController;

class CreditCardController implements Icontrollers{


    public function __construct(){
    }
    public function index(){
        
    }

    public function RetrieveByEmail($email)
    {
        $db = new CreditCardDB();
        return $db->RetrieveByEmail("manu");
    }

    public function RetrieveByNumber($number){
        $db = new CreditCardDB();
        return $db->RetrieveByNumber($number);
    }

}

?>