<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "Config/Data.php"; //aca estan las constantes
require_once "Config/Autoload.php";

/* Autoload */
use Config\Autoload as Autoload;

Autoload::start();
session_start();

/* Routing */
use Config\Router as Router;
use Config\Request as Request;

Router::route(new Request());

/* Check Session */
use controllers\UserController as UserController;
$checkSesion = new UserController();
$checkSesion->CheckSessionForView(); /*Chequeo de que en cada pagina el usuario se haya mantenido en sesion y que no se hay cambiado la contraseña */
