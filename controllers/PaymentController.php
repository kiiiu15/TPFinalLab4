<?php

namespace controllers;

use controllers\Icontrollers as Icontrollers;
use model\CreditCard as CreditCard;
use model\Ticket as Ticket;
use controllers\BuyController as BuyController;
use controllers\TicketController as TicketController;
use controllers\SessionManager as SessionManager;
use controllers\HomeController as HomeController;

class PaymentController implements Icontrollers
{
    private $buyController;
    private $ticketController;
    private $sessionManager;
    private $homeController;

    public function __construct()
    {
        $this->buyController = new BuyController();
        $this->ticketController = new TicketController();
        $this->sessionManager = SessionManager::getInstance();
        $this->homeController = new HomeController();
    }

    public function Validate($idBuy = 0, $number = "", $expirity = "", $expirityY = "", $security = "")
    {
        if ($idBuy == 0) {
            header("location:" . FRONT_ROOT);
        } else {
            $creditcard = new CreditCard("Banco Provincia", $number, $security, $expirity, $expirityY);
            $buy = $this->buyController->RetrieveById($idBuy);

            if (!$buy->getState()) {
                $validation = $this->ValidateCreditCard($creditcard);
                if ($validation == true) {
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

    public function ValidateCreditCard($creditcard)
    {
        $answer = true;
        return $answer;
    }

    public function GenerateTicket($idBuy)
    {
        try {
            $user = $this->sessionManager->GetUserLoged();
            $buy = $this->buyController->RetrieveById($idBuy);

            $qr = $this->ticketController->GenerateRandomString(4);
            $ticket = new Ticket(0, $qr, $buy);
            $this->ticketController->Add($ticket);

            $this->buyController->ChangeState($idBuy);

            $successMsg = "We thank you for your purchase";
            $this->ticketController->GenerateQR($qr);

            /*$mailController = new MailsController();
            $mailController->sendPurchaseEmail($idBuy, $qr);*/

            $this->homeController->index(null, null, $successMsg);
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
        include(PAGES . "/payment.php");
    }
}

