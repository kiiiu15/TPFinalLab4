<?php

include_once("config/autoload.php");
use config\autoload as autoload;
autoload::Start();
use repository\PeliRepository as PeliRepository; 
use repository\IRepository as IRepository; 

$repositorioPelis=new PeliRepository();

$array=$repositorioPelis->GetAll();



?>
