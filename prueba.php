<?php

include_once ("config/autoload.php");
use config\autoload as autoload;
autoload::Start();

use repository\PeliRepository as PeliRepository;

$repo = new PeliRepository();
$repo->RetrieveData();

?>