<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;

class HomeController implements Icontrollers {



    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer mas adelante */

        /*por ahora vamos al home */

        include(VIEWS."/home.php");
    }
}

?>