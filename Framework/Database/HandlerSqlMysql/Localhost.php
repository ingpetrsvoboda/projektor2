<?php
/**
 * POZOR - instance tohoto typu Projektor2_Adapter_Mysql_Localhost se používá k rozhodování a zobrazených informacích
 */
class Framework_Database_HandlerSqlMysql_Localhost extends Framework_Database_HandlerSqlMysql {

    public function __construct($dbName='', $user='', $pass='', $dbHost='', $dbPort='', $charset='') {
        parent::__construct("projektor_2", "root", "spravce", "localhost");
    }
}
