<?php

namespace controllers;

use Dao\CreditCardDB;
use model\CreditCard;

class CreditCardController implements Icontrollers
{
    private $creditCardDB;

    public function __construct()
    {
        $this->creditCardDB = new CreditCardDB();
    }

    public function index()
    {
        // Method implementation
    }

    public function Add($company, $number, $securityCode, $expiryMonth, $expiryYear)
    {
        $creditCard = new CreditCard($company, $number, $securityCode, $expiryMonth, $expiryYear);
        
        try {
            $this->creditCardDB->Add($creditCard);
        } catch (\Throwable $th) {
            echo "Error adding credit card";
        }
    }

    public function RetrieveByEmail($email)
    {
        try {
            return $this->creditCardDB->RetrieveByEmail($email);
        } catch (\Throwable $th) {
            return array();
        }
    }

    public function RetrieveByNumber($number)
    {
        try {
            return $this->creditCardDB->RetrieveByNumber($number);
        } catch (\Throwable $th) {
            return null;
        }
    }
}
