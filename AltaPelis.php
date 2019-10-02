<?php
/*$variable = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=f78530630a382b20d19bddc505aac95d&language=en-US&page=1");
$asd =($variable) ? json_decode($variable, true) : array() ;
var_dump($asd);
*/

include_once("config/autoload.php");
use config\autoload as autoload;
autoload::Start();
use repository\PeliRepository as PeliRepository; 
use repository\IRepository as IRepository; 

$repositorioPelis=new PeliRepository();

$repositorioPelis->RetrieveData();

$array=$repositorioPelis->GetMovieList();

var_dump($array);


?>