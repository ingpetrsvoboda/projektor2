<?php

//On Windows, setlocale(LC_ALL, '') sets the locale names from the system's regional/language settings (accessible via Control Panel). 
$locale = setlocale(LC_ALL, '');
        
######### EXCEPTION HANDLER ################################
/**
 * Exception handler zachytává všechny výjimky, vypíše českou hlavičku HTML a znovu výjimku vyhodí.
 */

function exceptionHandler($e) {
        // české texty v exceptions (i v xdebug), bez konce body a html si prohlížeč musí poradit
        echo
   '<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Content-Language" content="cs"> 
    </head>      
    <body>';
        throw $e;
}
//set_exception_handler('exceptionHandler');

// varianta pro ladění
// Při výskytu chyb libovolné úrovně PHP vyhodí výjimky s výpisem chyby. Bez tohoto error handleru se nezobrazují
// chyby PHP, pokud nejsou fatální. 
// Bohužel PHP neumožňuje vyhazovat výjimky uvnitř metody __toString(), proto je nutné ještě handler vypnout v Framework_View_Base->toString()

//pro ladění odkomentuj následující řádky
//function exception_error_handler($errno, $errstr, $errfile, $errline ) {
//    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
//}
//set_error_handler("exception_error_handler");

