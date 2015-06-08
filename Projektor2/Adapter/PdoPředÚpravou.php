<?php
/**
 * Description of Pdo
 *
 * @author pes2704
 */
class Projektor2_Adapter_Pdo_před_úpravou implements Framework_Database_PdoInterface {
    protected $config = array();
    protected $connection;
    protected $statement;
    protected $fetchMode = PDO::FETCH_ASSOC;  
     
    public function __construct($dsn, $username = null, $password = null, array $driverOptions = array()) {
        $this->config = compact("dsn", "username", "password", "driverOptions");
    }

    /**
     * 
     * @return type
     * @throws PDOException
     */
    public function getStatement() {
        if ($this->statement === null) {
            throw new PDOException(
              "There is no PDOStatement object for use.");
        }
        return $this->statement;
    }
    
    /**
     * 
     * @return type
     * @throws RunTimeException
     */
    public function connect() {
        // pokud existuje PDO object, vrací dříve vytvořený
        if ($this->connection) {
            return;
        }
  
        try {
            $this->connection = new PDO($this->config["dsn"], $this->config["username"], $this->config["password"], $this->config["driverOptions"]);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
     
    public function disconnect() {
        $this->connection = null;
    }
    
    /**
     * 
     * @param type $sql
     * @param array $options
     * @return \Framework_Database_HandlerPdo
     * @throws RunTimeException
     */
    public function prepare($sql, array $options = array()) {
        $this->connect();
        try {
            $this->statement = $this->connection->prepare($sql, $options);
            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
     
    public function execute(array $parameters = array()) {
        try {
            $this->getStatement()->execute($parameters);
            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
     
    public function countAffectedRows() {
        try {
            return $this->getStatement()->rowCount();
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
 
    public function getLastInsertId($name = null) {
        $this->connect();
        return $this->connection->lastInsertId($name);
    }
     
    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null) {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }
        try {
            return $this->getStatement()->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
      
    public function fetchAll($fetchStyle = null, $column = 0) {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }
        try {
            if ($fetchStyle === PDO::FETCH_COLUMN) {
                $resultSet = $this->getStatement()->fetchAll($fetchStyle, $column);
            } else {
                $resultSet = $this->getStatement()->fetchAll($fetchStyle);
            }
            return $resultSet;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }
     
    public function select($table, array $bind = array(), $boolOperator = "AND") {
        if ($bind) {
            $whereConditions = array();
            foreach ($bind as $col => $value) {
                $bindParams[":" . $col] = $value;
                $whereConditions[] = $col . " = :" . $col;
            }
        }
        $sql = "SELECT * FROM ".$table.$whereCondition;
        if ($bind) {
            $sql .= " WHERE ". implode(" ".$boolOperator." ", $whereConditions);
        }        
        $this->prepare($sql)->execute($bindParams);
        return $this;
    }
     
    public function insert($table, array $bind) {
        $cols = implode(", ", array_keys($bind));
        $values = implode(", :", array_keys($bind));
        foreach ($bind as $col => $value) {
            $bindParams[":" . $col] = $value;
        }
        $sql = "INSERT INTO ".$table." (".$cols.")  VALUES (:" .$values.")";
        return (int) $this->prepare($sql)->execute($bindParams)->getLastInsertId();
    }
     
    public function update($table, array $bind, $where = "") {
        $set = array();
        foreach ($bind as $col => $value) {
            $bindParams[":" . $col] = $value;
            $set[] = $col . " = :" . $col;
        }
        $sql = "UPDATE " . $table . " SET " . implode(", ", $set);
        if($where) {
            " WHERE " . $where;
        }
        return $this->prepare($sql)->execute($bindParams)->countAffectedRows();
    }
     
    public function delete($table, $where = "") {
        $sql = "DELETE FROM " . $table;
        if ($where) {
            $sql .=" WHERE " . $where;
        }
        return $this->prepare($sql)->execute()->countAffectedRows();
    }
}
