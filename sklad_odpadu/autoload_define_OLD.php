<?php

/*
 * Tento soubor obsahuje pouze definice konstant a include path
 * Pokud by byly v souboru autoload.php, docházelo by díky opakovanému volání __autoload k opakovanému
 * hlášení chyb úrovně NOTICE Constant xxxxx already defined
 */
	define("SEPARATOR", "_");   //oddělovač v názvech tříd
        define("PATH_SEPARATOR", ";"); //oddělovač jednotlivých cest pro set_iclude_path
	define("CLASS_PATH", "classes/");
	define("PEAR_PATH", "C://xampp/php/PEAR/");
      	define("MAPPER_SUFFIX", "_mapper");  // zpetna kompatibilita se starym kodem

        set_include_path(PEAR_PATH);

?>
