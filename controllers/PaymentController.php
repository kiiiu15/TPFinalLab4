<?php

namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use controllers\TicketController as TicketController;
use controllers\BuyController as BuyController;
use controllers\HomeController as HomeController;
use controllers\MailsController as MailsController;

use model\Buy as Buy;
use model\User as User;
use model\CreditCard as CreditCard;
use model\Ticket as Ticket;

use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;

class PaymentController implements Icontrollers
{


    public function Validate($idBuy = 0, $number = "",  $expirity = "", $expirityY = "", $security = "")
    {

        if ($idBuy == 0) {
            header("location:" . FRONT_ROOT);
        } else {
            $creditcard = new CreditCard("Banco Provincia", $number, $security, $expirity, $expirityY);

            $buyC = new BuyController();
            $buy = $buyC->RetrieveById($idBuy);

            if (!$buy->getState()) {
                $validation = $this->ValidateCreditCard($creditcard);
                if ($validation == true) {
                    $discount = $buy->getDiscount();
                    $total = $buy->getTotal();
                    $this->GenerateTicket($idBuy);
                } else {
                    $alertCreditCard = "Sorry, there was an error with some credit card field. Verify if the data is correct";
                    $this->index($alertCreditCard, $buy);
                }
            } else {
                header("location:" . FRONT_ROOT);
            }
        }
    }

    private function TransformToArray($value)
    {
        if ($value == false) {
            $value = array();
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        return $value;
    }

    //Es un prototipo
    public function ValidateCreditCard($creditcard)
    {
        /*  $userController = new UserController();
        $user = $userController->GetUserLoged();
        $creditcardList = array();
        $creditcardList = $user->getCreditCards();

        $creditcardList = $this->TransformToArray($creditcardList);     */

        $answer = true;
        /*
        $answer = false;

        foreach($creditcardList as $creditcardUser){

            if($creditcardUser->getNumber() == $creditcard->getNumber()){
                
                if($creditcardUser->getSegurityCode() == $creditcard->getSegurityCode()){
                    
                    if($creditcardUser->getExpiryMonth() == $creditcard->getExpiryMonth()){
                      
                        if($creditcardUser->getExpiryYear() == $creditcard->getExpiryYear()){
                            
                            $answer = true;
                        }
                    }
                }
            }
        }*/

        return $answer;
    }

    public function GenerateTicket($idBuy)
    {
        $buyController = new BuyController();
        $ticketController = new TicketController();
        $userController = new UserController();
        $homeC = new HomeController();

        try {
            $user = $userController->GetUserLoged();

            $buy = $buyController->RetrieveById($idBuy);

            $qr = $ticketController->GenerateRandomString(4); //AUN FALTA TERMINARLA 
            $ticket = new Ticket(0, $qr, $buy);
            $ticketController->Add($ticket);

            $buyController->ChangeState($idBuy);

            $successMsg = "We thank you for your purchase";
            $ticketController->GenerateQR($qr);

            /*$mailController = new MailsController();

            $mailController->sendPurchaseEmail($idBuy, $qr);*/

            $homeC->index(null, null, $successMsg);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function index($alertCreditCard = null, $buyP = null)
    {

        $errorMje = $alertCreditCard;
        if ($buyP != null) {
            $buy = $buyP;
        }
        $discount = 0;
        $total = 0;
        include(VIEWS . "/payment.php");
    }
}
