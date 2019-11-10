<?php namespace controllers;

use \PDO as PDO;
use \Exception as Exception;
use controllers\Icontrollers as Icontrollers;
use controllers\MovieFunctionController as MovieFunctionController;
use controllers\UserController as UserController;
use controllers\TicketController as TicketController;
use controllers\BuyController as BuyController;



use model\Buy as Buy;
use model\User as User;
use model\CreditCard as CreditCard;

use Dao\BuyDB as BuyDB;
use Dao\UserDB as UserDB;

class PaymentController implements Icontrollers{


    //Es un prototipo
    public function ValidateCreditCard($creditcard){
        $userController = new UserController();
        $user = $userController->GetUserLoged();
        $creditcardList = array();
        $creditcardList = $user->getCreditCards();
        $answer = false;

        foreach($creditcardList as $creditcardUser){
            if($creditcardUser->getNumber() == $creditcard->getNumber()){
                if($creditcardUser->getSegurityCode() == $creditcard->getSegurityCode()){
                    $answer = true;
                }
            }
        }
        if($answer == true){
            $this->GenerateTicket();
        }else{
            $alertCreditCard = "Sorry, there was an error with some credit card field. Verify if the data is correct";
            include(VIEWS ."/payment.php");
        }        
    }

    public function GenerateTicket(){
        $buyController = new BuyController();
        $ticketController = new TicketController();
        $userController = new UserController();
        
        try{
            $user = $userController->GetUserLoged();

            $buy = $buyController->RetrieveByUser($user);

            $qr = $this->GenerateQR(); //AUN FALTA TERMINARLA 
            $ticket = new Ticket(0,$qr,$buy);
            $ticketController->Add($ticket);

            $buyController->ChangeState($buy->getIdBuy());

            $successMsg = "We thank you for your purchase";
            include(VIEWS ."/posts.php");
        }catch(\PDOException $ex){
            throw $ex;
        }
        


        
    }
    
    //AUN FALTA TERMINARLA 
    public function GenerateQR(){}

    public function index(){

    }

}

?>