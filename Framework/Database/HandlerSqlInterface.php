<?php
/**
 *
 * @author pes2704
 */
interface Framework_Database_HandlerSqlInterface extends Framework_Database_HandlerInterface {
    
    /**
     * Metoda formátuje identifikátory pro použití v SQL dotazu podle typu konkrétní databáze. 
     * Např. přidá před a za identifikátor "databázové" uvozovky v případě MySQL databáze.
     * @param string $identificator
     */
    public function getFormattedIdentificator($identificator);
    
    /**
     * Vrací typ databáze (databázového driveru) ve formátu použitém pro dsn PDO. Vrací tedy název databázového driveru
     * např. 'mysql', 'sqlsrv'.
     */
    public function getDbType();
        
    /**
     * Metoda vytvoří dsn z vlastností objektu ve tvaru pro příslušný databázový stroj (MySQL, MSSQL apod.)
     */
    public function getDsn();
    
}
