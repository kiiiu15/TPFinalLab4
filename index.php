<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Config/Data.php";//aca estan las constantes
require_once "Config/Autoload.php";
require_once "Config/Request.php";
require_once "Config/Router.php";


use Config\Autoload as Autoload;
use Config\Router as Router;
use Config\Request as Request;

Autoload::start();
session_start();



Router::route(new Request());

use controllers\UserController as UserController;

$checkSesion = new UserController();
$checkSesion->CheckSessionForView(); /*Chequeo de que en cada pagina el usuario se haya mantenido en sesion y que no se hay cambiado la contraseña */



//ESTO ES PARA PROBAR EL LOGIN DE FB
if(!isset($_SESSION)){
    session_start();
}

?>
