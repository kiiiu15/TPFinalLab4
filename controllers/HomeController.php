<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;

class HomeController implements Icontrollers {



    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */

        if(!isset($_SESSION["status"]) || $_SESSION["status"] != "on")
        {
            require(VIEWS."/login.php");
        }else{
            include(VIEWS."/home.php");
        }

    }
}

?>