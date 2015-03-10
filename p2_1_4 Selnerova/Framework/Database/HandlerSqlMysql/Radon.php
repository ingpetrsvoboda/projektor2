<?php
class Framework_Database_HandlerSqlMysql_Radon extends Framework_Database_HandlerSqlMysql {
    public function __construct($dbName='', $user='', $pass='', $dbHost='', $dbPort='', $charset='') {
        parent::__construct("projektor_2", "root", "spravce", "radon");
    }
}

?>