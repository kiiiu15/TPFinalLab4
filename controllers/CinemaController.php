<?php 
namespace controllers;

use controllers\Icontrollers as Icontrollers;
use model\Cinema as Cinema;


class CinemaController implements Icontrollers{

    public function add ($cinemaName = "" , $capacity = 0 , $adress = "" , $entranceValue = 0 ) {
        
    }

    public function index(){
        include(VIEWS. "/home.php");
    }

}

?>