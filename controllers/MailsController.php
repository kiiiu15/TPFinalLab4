<?php 
namespace controllers;

use controllers\BuyController as BuyController;
use controllers\UserController as UserController;
use Dao\UserDB as UserDB;
use Dao\BuyDB as BuyDB;

use model\PHPMailer as PHPMailer;
use model\Exceptionn as Exceptionn;
use model\SMTP as SMTP;


class MailsController 
{
    
    public function sendPurchaseEmail(/*Purchase $purchase,$qrsToSend*/)
    {
        //BUSCA EL USUARIO LOGEADO !! 
        $user = $_SESSION["loged"];
        $mail = new PHPMailer(true);
        
        $buy = $_SESSION['buy'];
        //Traigo el objeto compra segun el usuario logeado
        /*$buyC = new BuyController();
        $buy = $buyC->RetrieveByUser($user);
        */

    try {
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'MoviePass12311@gmail.com';                     // SMTP username
        $mail->Password   = 'phpsucks';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('MoviePass12311@gmail.com', 'MoviePass Purchase');
        $emailToSend = $user->getEmail();
        $mail->addAddress($emailToSend, 'User');     // Add a recipient
   // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Thanks you for the purchase';
       
              // $mail->addAttachment("../QR/temp/$photo");         // Add attachments
           //  $mail->addAttachment("../QR/temp/$photo", 'new.jpg');    // Optional name
       
      /*     foreach ($qrsToSend as $item){
            $photo=$item->getFileName();
            $mail->AddEmbeddedImage("QR/temp/$photo","qr");
           }*/
        
        $mail->Body    = '<BODY BGCOLOR="White">
<body>
<div Style="align:center;">
<p> PURCHASE INFORMATION  </p>
<pre>
<p>'."Date:". $buy->getDate() ."</p>
<p>TicketsAmount: " .$buy->getNumberOfTickets()."</p>
<p>Discount: " . $buy->getDiscount()."</p>
<p>TOTAL: " .$buy->getTotal()."</p>".'
</pre>
<p>
</p>
</div>
</br>
<div style=" height="40" align="left">
<font size="3" color="#000000" style="text-decoration:none;font-family:Lato light">
<div class="info" Style="align:left;">           

<br>
<p>Company:   MoviePass   </p> 
<br>
</div>

</br>
<p>-----------------------------------------------------------------------------------------------------------------</p>
</br>
<p>( This is an automated message, please do not reply to this message, if you have any queries please contact CinemAppSuppUTN@gmail.com )</p>
</font>
</div>
</body>';


        $mail->send();
        
    } catch (Exceptionn $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }
}















?>