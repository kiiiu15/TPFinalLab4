<?php
require_once "Config/Data.php";
if(!isset($_SESSION)){
    session_start();
}

require(ROOT."/vendor/autoload.php");

$fb = new Facebook\Facebook([
    'app_id' => '513671089475368',
    'app_secret' => '6711f1640f48f0620d9e5dfe6e6dd15a',
    'default_graph_version' => 'v2.7'
]);

$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl("http://localhost/TPFinalLab4");

//print_r($login_url);

try{
    $accessToken = $helper->getAccessToken();
    if(isset($accessToken)){
        echo "<br>entre al if<br>";
        $_SESSION['access_token'] = (string)$accessToken;
        include("index.php");
    }
} catch (Exception $exc){
    
    var_dump(  $exc->getTraceAsString() );
}
?>