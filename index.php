<?php
// 20150524 22:57
ob_start();
// exception handler
require_once 'Bootstrap.php';
// zajištění autoload pro Projektor
require_once 'Projektor2/Autoloader.php';
Projektor_Autoloader::register();
require_once 'Classes/PHPExcel.php';  // uvnitř v Classes/PHPExcel.php se provede PHPExcel_Autoloader::Register();

$request = new Projektor2_Request();
$response = new Projektor2_Response();
//$app = new Projektor2_Application($request, $response);

$sessionStatus = Projektor2_Model_SessionStatus::createSessionStatus($request, $response);

$pageController = new Projektor2_Controller_Page($sessionStatus, $request, $response);
$response->setBody($pageController->getResult());
$sessionStatus->persistSessionStatus($request, $response);
$response->send();
?>
