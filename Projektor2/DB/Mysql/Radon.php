<?php
class Projektor2_DB_Mysql_Radon extends Projektor2_DB_Mysql {
    protected $user   = "root" ;          //projektor";
    protected $pass   = "spravce";             //Vekt0r";
    protected $dbhost =  "radon" ;     //"localhost" ;       // "xenon" ;  "localhost" ;    
    protected $dbname =  "projektor_2" ;     //"projektor_2_00_centrala_cvicna" ;        //"projektor_2_00_centrala" ;
    
    //protected $dbhost = "radon" ;    //"localhost" ;     //"radon";     //"localhost" ;        
    //protected $dbname = "projektor_2_00_centrala" ; //"projektor_2_00_centrala_111017" ;     //"projektor_2_00_centrala_cvicna" ;        //"projektor_2_00_centrala" ;  "projektor_3_00_centrala_vyvoj" ; 


    public function __construct() { }
}

?>