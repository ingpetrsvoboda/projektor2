<?php
ob_start();
// zajištění autoload pro Projektor
require_once 'Projektor2/Autoloader.php';
Projektor_Autoloader::register();

$request = new Projektor2_Request();
$response = new Projektor2_Response();
//$app = new Projektor2_Application($request, $response);

$dbh = Projektor2_AppContext::getDb();

$lastname=trim(@$_COOKIE['lastname']);
$lastprojektkod=@$_COOKIE['lastprojektkod'];
//$lastkancelarkod=@$_COOKIE['lastkancelarkod'];
$response->setCookie("behId");
$response->setCookie("zajemceId");
$response->setCookie("ucastnikId");
$response->setCookie("projektId");
//$response->setCookie("kancelarId");
  
$uri = $request->get('originating_uri');
//Když se přijde z index.php - je vše OK, když se přijde z login.php (odeslání přihlašovacího formuláře) není nastaven @$_REQUEST['originating_uri']
// a tak se to napraví natvrdo takto:
if(!$uri) {
    $uri = "./index.php";
}

$warning = $request->get('warning');

if($request->isPost()){
    $name = $request->post('name');
    $password = $request->post('password');
    $projektkod = $request->post('projekt');
//    $kancelarkod = $request->post('kancelar');
    $response->setCookie("lastname",$name,time()+3600);
    $response->setCookie("lastprojektkod",$projektkod,time()+3600);
//    $response->setCookie("lastkancelarkod",$kancelarkod,time()+3600);
    if($request->post('projekt') == "ß") {
	$warning = "projekt";
	header("Location: ./login.php?uri=$uri&warning=$warning");  // vyvolá GET request
        $response->send();
	exit;
    }
    $userid = Projektor2_Auth_Authentication::check_credentials($name,$password);    
    if($userid){

	$authCookie = new Projektor2_Auth_Cookie($response, $userid);
	$authCookie->set();

//	$kancelar = Projektor2_Model_Db_KancelarMapper::findByKod($kancelarkod);   
	$projekt = Projektor2_Model_Db_ProjektMapper::findByKod($projektkod);      
	if (isset($projekt)) {
            $response->setCookie("projektId",$projekt->id);
        } else {
            $response->setCookie("projektId");            
        }
//        if (isset($kancelar)) {
//            $response->setCookie("kancelarId",$kancelar->id);
//        } else {
//            $response->setCookie("kancelarId");
//        }

	header("Location: $uri");
        $response->send();
	exit;
    } else {
	$warning = "name";
	header("Location: ./login.php?uri=$uri&warning=$warning");
        $response->send();
        exit;        
    }
}
 //vydumpovani  databaze
 //exec("C:\\XAMPP\\mysql\\bin\\mysqldump --user=root --password=spravce projektor2kancelar>D:\\%COMPUTERNAME%_sql.sql");


$response->setBody('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
    <head>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
        <title>Grafia.cz | Projektor | Přihlášení k systému</title>
    </head>
    <body>');

    if($warning=="name") {
        $response->appendToBody('<p  style="color: red"><strong>Přihlášení se nezdařilo</strong></p>');
    }
    if($warning=="projekt") {
        $response->appendToBody('<p  style="color: red"><strong>Prosím vyberte projekt ke kterému se chcete přihlásit a přihlašte se znovu !</strong></p>');
    }
    $response->appendToBody('<strong>Přihlášení do systému projektor</strong>
	<form name="Login" ID="Login" action="login.php" method="post">
	    <input type="hidden" name="sent" value="1">
	    <table>
		<tr>
		    <td><label for="text2" >Uživatelské jméno:</label></td>
		    <td><input  type ="text" name="name" ID="Text2" value="'.$lastname.'"></td>
		</tr>
		<tr>
		    <td><label for="Password2" >Heslo:</label></td>
		    <td><input type="password" name="password" ID="Password2" class="txtinput"></td>
		</tr>
		<tr>
		    <td><label for="Projekt" >Projekt</label></td>
		    <td><select ID="Projekt" size="1" name="projekt">');

    $query = "SELECT kod,text FROM c_projekt WHERE valid=True";
    $sth = $dbh->prepare($query);
    $succ = $sth->execute();
    while($zaznam = $sth->fetch()) {
	$response->appendToBody("\t\t\t<option ");
	if($zaznam['kod'] == $lastprojektkod) {
	    $response->appendToBody(" selected ");
	}
	$response->appendToBody("value=\"".$zaznam['kod']."\">".$zaznam['text']."</option>\n");
    }
$response->appendToBody('
			</select>
		    </td>
		</tr>');
//$response->appendToBody('<tr>
//		    <td><label for="Kancelar" >Kancelář</label></td>
//		    <td><select ID="Kancelar" size="1" name="kancelar">');
//
//    $query = "SELECT kod,text FROM c_kancelar WHERE valid=1";
//    $sth = $dbh->prepare($query);
//    $succ = $sth->execute();
//    while($zaznam = $sth->fetch()) {
//	$response->appendToBody( "\t\t\t<option ");
//	if($zaznam['kod'] == $lastkancelarkod) {
//	    $response->appendToBody( " selected ");
//	}
//	$response->appendToBody( "value=\"".$zaznam['kod']."\">".$zaznam['text']."</option>\n");
//
//    }
//    
//$response->appendToBody('
//			</select>
//		    </td>
//		</tr>');
$response->appendToBody('<tr>
		    <td></td>
		    <td colspan="2">
			<input type="submit" value="Přihlásit" ID="Submit2" NAME="Submit1" class="btn">
		    </td>
		</tr>
	    </table>
	</form>
    </body>
</html>');

$response->send();

