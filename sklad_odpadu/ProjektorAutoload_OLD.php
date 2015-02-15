<?php

function ProjektorAutoload($className) {
	
	// patch - zpetna kompatibilita se starym kodem
	if(strripos($className, MAPPER_SUFFIX)) {
            $className = str_ireplace(MAPPER_SUFFIX, "", $className);
            include(CLASS_PATH . str_replace(SEPARATOR, "/", $className) . "_mapper.php");
            return;
	}
        
        // patch - fpdf - nedodržuje standard pojmenovávání class s podtržítky PEAR
        if(@include(PEAR_PATH . 'fpdf/' . $className . '.php')) {
            return;
        } else {
            $path = str_replace(SEPARATOR, "/", $className) . ".php";
            //patch - PHP Excel se sám nainstaluje adresáře PEAR/PHPExcel/PHPExcel/jednotlivé_soubory.php
            if (@include(PEAR_PATH . "PHPExcel/" . $path)) {
                return;
            } else {
                if(@include(PEAR_PATH . $path)) {
                    return;
                } else {
                    include(CLASS_PATH . $path);
                }
            }
        
        }
  
}
//$aload = spl_autoload_functions();
spl_autoload_register('ProjektorAutoload');
//$aload = spl_autoload_functions();
?>