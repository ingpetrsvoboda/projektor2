<?php

function __autoload($className) {
	
	define("SEPARATOR", "_");
	define("CLASS_PATH", "classes/");	
	define("MAPPER_SUFFIX", "_mapper");  // zpetna kompatibilita se starym kodem
	
	//echo(substr_compare($className, MAPPER_SUFFIX, strlen($className)-strlen(MAPPER_SUFFIX), strlen(MAPPER_SUFFIX)));

	if(strripos($className, MAPPER_SUFFIX))
	{
		$className = str_ireplace(MAPPER_SUFFIX, "", $className);
		include(CLASS_PATH . str_replace(SEPARATOR, "/", $className) . "_mapper.php");
	}
	else
	{
  		//přílepek pro volání fpdf
    	//$_SERVER['LD_LIBRARY_PATH']  je XAMPP path k adresáři obsahujícímu PEAR adresář
//    	if(@include($_SERVER['LD_LIBRARY_PATH'] . '/PEAR/fpdf/' . $className . '.php'))
    	if(@include('C://xampp/php' . '/PEAR/fpdf/' . $className . '.php'))
		{
        	return;
    	}
    	else
    	{
    		include(CLASS_PATH . str_replace(SEPARATOR, "/", $className) . ".php");
    	}
	}
  
}

?>