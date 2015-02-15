<?php
class Projektor2_DB_Mysql_Localhost extends Projektor2_DB_Mysql {
    protected $user   = "root";
    protected $pass   = "spravce";
    protected $dbhost = "localhost";
    protected $dbname = "projektor_2";

    public function __construct() { }
}

?>