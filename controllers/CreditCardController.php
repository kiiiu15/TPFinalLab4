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

    public function Add($company,$number,$securityCode,$expiryMonth,$expiryYear){
        $creditCard = new CreditCard($company,$number,$securityCode,$expiryMonth,$expiryYear);
        $db = new CreditCardDB();
        try {
            $db->Add($creditCard);
        } catch (\Throwable $th) {
            echo "Problema al agregar tarjeta";
        }
        
    }

    public function RetrieveByEmail($email)
    {
        $db = new CreditCardDB();

        try {
            return $db->RetrieveByEmail($email);
        } catch (\Throwable $th) {
            return array();
        }
        
    }

    public function RetrieveByNumber($number){
        $db = new CreditCardDB();
        try {
            return $db->RetrieveByNumber($number);
        } catch (\Throwable $th) {
            return null;
        }
        
    }

}

?>