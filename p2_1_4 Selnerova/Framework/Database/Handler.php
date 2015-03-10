<?php
/**
 * Description of Framework_Database_HandlerSql
 * Základní handler objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDO a jde o adapter a současně wrapper pro PDO.
 * Potomkovské objekty musí inmplementovat vlastní metodu getDsn(), která musí vracet takové dsn, které odpovídá typu 
 * databáze. Tedy v případě PDO typu databázového driveru PDO.
 *
 * @author pes2704
 */
abstract class Framework_Database_Handler implements Framework_Database_HandlerInterface {
    
    /**
     * Defaultní typ objektu vraceného metodou prepare()
     */
    const RETURNED_STATEMENT_OBJECT_TYPE = 'Framework_Database_PdoStatement';
    
    protected $dbName;
    protected $user;
    protected $pass;
    protected $dbHost;
    protected $dbPort;
    
    protected $charset;

    protected $dsn;
      

    /**
     * Metoda mění adapter na kombinaci adapteru a wrapperu. Pro metody implementované v této třídě se objekt chová jako adapter, 
     * volá se implementovaná metoda třídy. Pro neimplementované metody se volá metoda "obaleného" objektu, v tomto případě tedy metoda PDO.
     * @param type $method
     * @param array $arguments
     * @return type
     */
    public function __call($method, array $arguments )
    {
        return call_user_func_array(array($this, $method), $arguments);
    } 
    
    public function getCharset() {
        return $this->charset;
    }
    
    public function getDbName() {
        return $this->dbName;
    }
    
    public function getDbHost() {
        return $this->dbHost;
    }
    
    public function getUser() {
        return $this->user;
    }
}
