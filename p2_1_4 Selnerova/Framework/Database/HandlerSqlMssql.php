<?php 
use Framework_Database_HandlerSql;
class Framework_Database_HandlerSqlMssql extends Framework_Database_HandlerSql implements Framework_Database_HandlerSqlInterface {
    
    public function getFormattedIdentificator($identificator) {
        return "[".$identificator."]";
    }
    
    public function getDsn() {
        $dsn = $this->getDbType() . ':Server=' . $this->dbHost .
                      ((!empty($this->dbPort)) ? (', ' . $this->dbPort) : '') .
                      ';Database=' . $this->dbName.
                      ((!empty($this->charset)) ? (';charset=' . $this->charset) : '');
        return $dsn;
    }
    
    public function getDbType() {
         return new Framework_DBPDO_DbType(Framework_Database_DbTypeEnum::MSSQL);
    }
}
?>