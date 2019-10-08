<?php
include_once("config/autoload.php");
use config\autoload as autoload;
use model\Cinema as Cinema;
use repository\CinemaRepository as CinemaRepository;
autoload::Start();

if(isset($_POST))
{
    $repo = new CinemaRepository();
    //var_dump($repo);
    $cineList = $repo->GetAll();
   // var_dump($cineList);
  //  var_dump($_POST);
    $newCine = new Cinema($_POST["id"],$_POST["name"],$_POST["address"],$_POST["capacity"],$_POST["value"]);
    
    if(!$repo->cinemaExist($_POST["id"]))
    {
        $repo->Add($newCine);
        echo "se agrego";
    }else {
        echo "no se agrego";
    }
    
    
}


?>