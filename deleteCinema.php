<?php

include_once("config/autoload.php");
use config\autoload as autoload;
use model\Cinema as Cinema;
use repository\CinemaRepository as CinemaRepository; 
use repository\IRepository as IRepository;
autoload::Start();

if(isset($_POST["id"])){

    $cinemaRepo=new CinemaRepository();

    $cinemaList=$cinemaRepo->GetAll();

    $idCinema=$_POST["id"];
    
    $aux=false;

    foreach ($cinemaList as $value) {
        if($idCinema == $value->getIdCinema()){
            $value->setActive($aux);
            echo "Se elimino";
            break;
        }
    }

}



?>