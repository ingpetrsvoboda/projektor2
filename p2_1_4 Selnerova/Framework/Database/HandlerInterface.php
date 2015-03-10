<?php
/**
 *
 * @author pes2704
 */
interface Framework_Database_HandlerInterface {
    
    public function __construct($dbName, $user, $pass, $dbHost, $dbPort, $charset);

    public function getCharset();
    public function getDbName();
    public function getDbHost();
    public function getUser(); 
}
