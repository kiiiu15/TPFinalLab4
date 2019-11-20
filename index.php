<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Config/Data.php";//aca estan las constantes
require_once "Config/Autoload.php";
require_once "Config/Request.php";
require_once "Config/Router.php";
//require_once "Daos/daoList/Singleton.php";
use Config\Autoload as Autoload;
use Config\Router as Router;
use Config\Request as Request;

Autoload::start();
session_start();
Router::route(new Request());




//ESTO ES PARA PROBAR EL LOGIN DE FB
if(!isset($_SESSION)){
    session_start();
}

?>
