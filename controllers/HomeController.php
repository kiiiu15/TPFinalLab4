<?php 
namespace controllers;



use controllers\Icontrollers as Icontrollers;



class HomeController implements Icontrollers {


    public function add ($element){
        
    }
    public function delete ($element) {

    }
    public function getAll(){

    }
    public function edit(){

    } 

    public function index (){
        /*Aca falta el formulario de logeo que vamos a hacer ams adelante */

        /*por ahora vamos al home */

        include(VIEWS."/home.php");
    }
}

?>