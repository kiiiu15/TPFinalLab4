<?php
if(!session_id())
    session_start();

require_once "Facebook/autoload.php";

$app_id= "429674224576137";
$app_secret="d8c3df0dd28220a92df2ce0df3e921b9";
$permissions = ['email']; // Optional permissions'

define('CURRENT_DIR', str_replace('\\','/',__DIR__ . "/"));
$base=explode($_SERVER['DOCUMENT_ROOT'],CURRENT_DIR);
define("FOLDER",$base[1]);

//$callbackUrl="http://localhost/" . FOLDER . "callback.php";
$callbackUrl= "http://localhost/TPFinalLab4/callback.php";
$fb = new Facebook\Facebook([
	'app_id' => $app_id, 
	'app_secret' => $app_secret,
	'default_graph_version' => 'v3.2',
	]);
$helper = $fb->getRedirectLoginHelper();
$loginUrl = $helper->getLoginUrl($callbackUrl, $permissions);
?>