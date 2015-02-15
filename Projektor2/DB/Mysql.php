<?php
class Projektor2_DB_Mysql implements Projektor2_DB_Connection {
  protected $user;
  protected $pass;
  protected $dbhost;
  protected $dbname;
  protected $dbh;
  protected $Db_user;
  
  public $infoDbHost;
  public $infoDbName;

  public function __construct($user, $pass, $dbhost, $dbname) {
    $this->user = $user;
    $this->pass = $pass;
    $this->dbhost = $dbhost;
    $this->dbname = $dbname (Db_user);
  }
  protected function connect() {
    $this->dbh = mysql_connect($this->dbhost, $this->user, $this->pass);
    if(!is_resource($this->dbh)) {
      throw new Projektor2_DB_MysqlException;
    }
    if(!mysql_select_db($this->dbname, $this->dbh)) {
      throw new Projektor2_DB_MysqlException;
    }
  }
  public function execute($query) {
    if(!$this->dbh) {
      $this->connect();
    }
    $ret = mysql_query($query, $this->dbh); 
    if(!$ret) {
      throw new Projektor2_DB_MysqlException;
    }
    else if(!is_resource($ret)) {
      return TRUE;
    } else {
      $stmt = new Projektor2_DB_MysqlStatement($this->dbh, $query);
      $stmt->result = $ret;
      return $stmt;
    }
  }
  public function prepare($query,$Db_user=False) {
    if(!$this->dbh) {
      $this->connect();
      //Nastaaveni znakove sady pro přenos dat
      mysql_query("SET CHARACTER SET utf8");
    }
    //Nastaveni uzivatele pro zaznam do tabulky aktualizaci
    if(!$Db_user) {
        mysql_query("SET @uz_jmeno = 1",$this->dbh);
    }
    else {
        $this->Db_user = $Db_user;
        mysql_query("SET @uz_jmeno = ".$this->Db_user->id.";",$this->dbh);
    }
        
    return new Projektor2_DB_MysqlStatement($this->dbh, $query);
  }


    public function __get($name) {
        if (isset($name)) 
        {
        	return $this->$name;
        }
        else
        {
            return false;
        }
    }
}
?>