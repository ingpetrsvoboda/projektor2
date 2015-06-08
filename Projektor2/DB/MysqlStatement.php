<?php
class Projektor2_DB_MysqlStatement implements Projektor2_DB_Statement {
  public $result;
  public $binds;
  public $query;
  public $dbh;
  public function __construct($dbh, $query) {
    $this->query = $query;
    $this->dbh = $dbh;
    if(!is_resource($dbh)) {
      throw new Projektor2_DB_MysqlException("Not a valid database connection");
    }
  }
  public function bind_param($ph, $pv) {
    $this->binds[$ph] = $pv;
    return $this;
  }
  
  /**
   * Metoda příjímá jeden paramet typu pole nebo řadu (libovolný počet) skalárních argumentů. Zadané argumenty naváže 
   * s připraveným dotazem (s touto instancí objektu Projektor2_DB_MysqlStatement)
   * @return \Projektor2_DB_MysqlStatement
   * @throws Projektor2_DB_MysqlException
   */
  public function execute() {

    $binds = func_get_args();
    if (is_array($binds[0]) AND count($binds)==1) {
        $binds = $binds[0];
    }
    $i = 1;
    foreach($binds as $name) {
      $this->binds[$i++] = $name;
    }
    $cnt = count($this->binds);
    $query = $this->query;
//echo "<br>PARA" ; print_r($binds);    
//echo "<br>" . $query;    
    for($i=$cnt;$i>0;$i--){
        $ph=strval($i);
        $pv=$this->binds[$i];
        if($pv =="NULL"){
            $query = str_replace(":$ph",mysql_real_escape_string($pv), $query);
        }
        else {
            $query = str_replace(":$ph", "\"".mysql_real_escape_string($pv)."\"", $query);
            $query = str_replace("~$ph", "`".mysql_real_escape_string($pv)."`", $query);
        }
        
    }
//echo("<p style=\"color:red\">{$query}</p>");
    $this->result = mysql_query($query, $this->dbh);
//echo "<br> RESULT" ;    
//print_r( $this->result );  var_dump  ( $this->result );  
    if(!$this->result) {
      throw new Projektor2_DB_MysqlException;
    }
    return $this;
  }
  public function fetch_row() {
    if(!$this->result) {
      throw new Projektor2_DB_MysqlException("Query not executed");
    }
    return mysql_fetch_row($this->result);
  }
  public function fetch_assoc() {
    return mysql_fetch_assoc($this->result);
  }
  public function fetchall_assoc() {
    $retval = array();
    while($row = $this->fetch()) {
      $retval[] = $row;
    }
    return $retval;
  }
  
  public function last_insert_id() {
  	return mysql_insert_id($this->dbh);
  } 
}

?>