<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*require_once "Config/Data.php";//aca estan las constantes
require_once "Config/Autoload.php";
require_once "Config/Request.php";
require_once "Config/Router.php";
//require_once "Daos/daoList/Singleton.php";
use Config\Autoload as Autoload;
use Config\Router as Router;
use Config\Request as Request;
//use daos\daoList\Singleton as Singleton;
Autoload::start();
session_start();
Router::route(new Request());
*/




if(!isset($_SESSION)){
    session_start();
}

require("fb-init.php");
if(isset($_SESSION['access_token'])){
    echo "<br>se cargo el access_token<br>";
}
?>


<!-- 
    NO LE PRESTEN ATENCION A ESTO, ES SOLO UNA PRUEBA PARA EL LOGIN DE FACEBOOK
    SI LO LOGRO HACER ANDA LO SACO DE ACA
 -->
<html>
<a href="<?php echo $login_url; ?>">log fb</a>
</html>