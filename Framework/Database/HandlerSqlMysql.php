<?php 
abstract class Framework_Database_HandlerSqlMysql extends Framework_Database_HandlerSql implements Framework_Database_HandlerSqlInterface {
    
    public function getFormattedIdentificator($identificator) {
        return "`".str_replace("`","``",$identificator)."`";;
    }
    
    public function getDsn() {
        $dsn = $this->getDbType();
        $dsn .= ':host=' . $this->dbHost .
                      ((!empty($this->dbPort)) ? (';port=' . $this->dbPort) : '') .
                      ';dbname=' . $this->dbName .
                      ((!empty($this->charset)) ? (';charset=' . $this->charset) : '');
        return $dsn;
    }
    
    public function getDbType() {
        $dbTypes = new Framework_Database_DbTypeEnum();
        return $dbTypes('MySQL');
    }    
    
    /**
     * Metoda rozšiřuje PDO pro MySQL (adaptér). Pro MySQL nefunguje pdo metoda last_row_count(), nahrazuji to
     * druhým volánám příkazu select s pouřitím MySQL funkce FOUND_ROWS(), která vrací počet řádek posledního provedeného selectu.
     * Viz  http://dev.mysql.com/doc/refman/5.1/en/information-functions.html#function_found-rows
     * 
     * @return type
     */
    public function last_row_count() {
        return $this->query("SELECT FOUND_ROWS()")->fetchColumn();
    }    
}
?>