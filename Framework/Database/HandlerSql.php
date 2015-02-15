<?php
/**
 * Description of Framework_Database_HandlerSql
 * Základní handler objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDO a jde o adapter a současně wrapper pro PDO.
 * Potomkovské objekty musí inmplementovat vlastní metodu getDsn(), která musí vracet takové dsn, které odpovídá typu 
 * databáze. Tedy v případě PDO typu databázového driveru PDO.
 *
 * @author pes2704
 */
abstract class Framework_Database_HandlerSql extends PDO implements Framework_Database_HandlerInterface {
    
    /**
     * Defaultní typ objektu vraceného metodou prepare()
     */
    const RETURNED_STATEMENT_OBJECT_TYPE = 'Framework_Database_StatementSql';
    
    protected $dbName;
    protected $user;
    protected $pass;
    protected $dbHost;
    protected $dbPort;
    
    protected $charset;

    protected $dsn;
    
    /**
     * Konstruktor. Nastaví instanční proměnné zadané jako parametry, sestaví řetězec DSN a volá rodičovský konstruktor.
     * Metoda tedy vrací rozšířený objekt PDO. DSN je sestaven a PDO je vytvořeno tak, že je zachováno použití znakové sady UTF-8, která je defaultní. 
     * Vrácený objekt tedy lze použít poue pro tabulky v kódování UTF-8 a vstupní(výstupní) kódování je také vždy UTF-8.
     * @param string $dbName
     * @param string $user
     * @param string $pass
     * @param string $dbHost
     * @param string $dbPort
     */
    public function __construct($dbName, $user, $pass, $dbHost, $dbPort=NULL, $charset = 'UTF8') {
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        $this->dbHost = $dbHost;
        $this->dbPort = $dbPort;
        $this->charset = $charset;
        parent::__construct($this->getDsn(), $this->user, $this->pass);
        //option zadané v parametrech se následně přepíší deault hodnotami:
        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array(self::RETURNED_STATEMENT_OBJECT_TYPE, array()));   // vracej VLASTNÍ objekt statement zadaného typu
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // při chybě vyhazuj výjimky
        $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');  // použij výhradně kódování utf8
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);  //pokoušej se používat nativní poporu preparu poskytovanou driverem
        // ???? (PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL) - viz sERGE-01 http://php.net/manual/en/pdostatement.rowcount.php#113608
        
    }    

    /**
     * Metoda mění adapter na kombinaci adapteru a wrapperu. Pro metody implementované v této třídě se objekt chová jako adapter, 
     * volá se implementovaná metoda třídy. Pro neimplementované metody se volá metoda "obaleného" objektu, v tomto případě tedy metoda PDO.
     * @param type $method
     * @param array $arguments
     * @return type
     */
    public function __call($method, array $arguments )
    {
        return call_user_func_array(array($this->datab, $method), $arguments);
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
