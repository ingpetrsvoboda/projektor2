<?php
ob_start();
// zajištění autoload pro Projektor
require_once 'Projektor2/Autoloader.php';
Projektor_Autoloader::register();

$request = new Projektor2_Request();
$response = new Projektor2_Response();

$response->setCookie("behId");
$response->setCookie("id_zajemce");
$response->setCookie("id_ucastnik");
$response->setCookie("projektId");
$response->setCookie("kancelarId");

$cookie = new Projektor2_Auth_Cookie($response);
$cookie->logout();
header("Location: ./login.php"); 
    $response->send();
    exit;    
?>