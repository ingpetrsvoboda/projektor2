<?php
class Framework_Model_ItemFlatTableOLD extends Framework_Model_DbItemAbstract {
    public $tableName;
    public $mainObjectIdColumnName;
    public $id;
    public $mainObject;

    
    protected $names = array();
    protected $types = array();
    protected $lengths = array();
    protected $isNulls = array();
    protected $primaryKeyColumnName;
    protected $values = array();
    protected $signes = array();
    protected $defaults = array();

    /**
     * Konstruktor
     * @param type $tableName Název db tabulky
     * @param type $mainObject
     * @param type $idColumnName Název sloupce s primátním klíčem db tabulky $table_name. Pokud parametr není zadán, 
     * metoda použije default hodnotu složenou z prefixu 'id_' a názvu tabulky (např. pro název tabulky 'osoba' použije !id_osoba'
     * @throws Exception
     */
    public function __construct($tableName,$mainObject, $idColumnName=NULL) {          
        $this->tableName = $tableName;
        $this->mainObject = $mainObject;
        $mainObjectClassName = get_class($mainObject);
        if ($idColumnName){
            $this->mainObjectIdColumnName = $idColumnName;
        } elseif ($mainObjectClassName::TABLE) {
            $this->mainObjectIdColumnName = 'id_'.$mainObjectClassName::TABLE;
            } else {
                throw new Exception("Method parameter $idColumnName isn't set and context object $mainObjectClassName hasn't constant TABLE" );
            }
        $this->chyby = new Projektor2_Chyby();

        $dbh = Projektor2_AppContext::getDb();
        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
        $query = "SHOW COLUMNS FROM ".$this->tableName;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        while ($data = $sth->fetch(PDO::FETCH_ASSOC)){
            $this->names[] = $data['Field'];
            $this->defaults[] = $data['Default'];
            $this->types[] = $data['Type'];
            $this->isNulls[] = $data['Null'];
            if ($data['Key']=="PRI") $this->primaryKeyColumnName = $data['Field'];
            $this->values[] = '';        
        }
    }
    
    public function __get($name){
        $varkey = array_search($name,$this->names);
        if($varkey === FALSE){
            return NULL;
        } else {
            $this->read();
            return $this->values[$varkey];
        }
    }
        
    public function __set($name,$value){
        $varkey = array_search($name,$this->names);
        if($varkey === false){
            return NULL;
        } else {
            $this->read();
            $this->values[$varkey] = $value;
            return $value;
        }
    }
    
    public function save() {
        if(!$this->mainObject->id){
            throw new Exception("Flat_table's main object hasn't id,cann't save vaules into table ".$this->tableName);
        }
//        $dbh = Projektor2_AppContext::getDB();
//    
//        $query="SELECT count(*) as pocet_r from " . $this->tableName ;  //pro zjisteni , zda neco vymaze
//        $sth = $dbh->prepare($query);
//        $sth->execute($this->mainObject->id);
//        $exdetekce = $exres->fetch(); 
//        $pocet_r1 = $exdetekce['pocet_r']; 
//    
//        $query="DELETE FROM ".$this->tableName."
//                WHERE ".$this->mainObjectIColumnName." = :1";        
//        $exres = $dbh->prepare($query)->execute($this->mainObject->id);
//                
//        $query="SELECT count(*) as pocet_r from " . $this->tableName ;     //pro zjisteni , zda neco vymazal
//        $exres = $dbh->prepare($query)->execute(array($this->mainObject->id));
//        $exdetekce = $exres->fetch(); 
//        $pocet_r2 = $exdetekce['pocet_r']; 
//        
//        $mainObjectIdColumnKey = array_search($this->mainObjectIColumnName, $this->names);
//        $this->values[$mainObjectIdColumnKey] = $this->mainObject->id;
//        $query="INSERT INTO ".$this->tableName." (";
//        foreach($this->names as $varname) {
//            $query.=$varname.",";
//        }
//        $query=substr($query,0,strlen($query)-1);
//        $query.=") VALUES (";
//        foreach($this->values as $varvalue) {
//            $default= each ($this->defaults) ;
//            if($varvalue) {
//                $query.="'".$varvalue."',";
//            } else {
//                if ( $pocet_r1 != $pocet_r2 ) {   //veta uz tam byla    -  "update"
//                    $query.="NULL,";
//                } else {                  //veta  tam nebyla    -  "insert"
//                    if  ($default['value']) {
//                        $query.="'" . $default['value']  ."',";
//                    } else {
//                        $query.="NULL,";
//                    } 
//                }                           
//            }
//        }
//        $query=substr($query,0,strlen($query)-1);
//        $query.=");";
//
//        $dbh->prepare($query)->execute();
//        $query="SELECT last_insert_id()";
//        list($this->id) = $dbh->prepare($query)->execute()->fetch_row();
//        return $this;
    }
    
    private function read() {
        if (!$this->isHydrated) {
            if(!$this->mainObject->id){
                throw new Exception("Flat table's has no main object or main object has no id,cann't read vaules from table ".$this->tableName);
            } else {
                $dbh = Projektor2_AppContext::getDb();
                $query="SELECT * FROM ".$this->tableName."
                        WHERE ".$this->mainObjectIdColumnName." = :main_object_id";
                $bindParams = array('main_object_id'=>$this->mainObject->id);
                $sth = $dbh->prepare($query);
                $succ = $sth->execute($bindParams);
                $data = $sth->fetch(PDO::FETCH_ASSOC);  
                if(!$data) {
                    return NULL;
                }
                foreach($this->names as $columnid => $columnname) {
                    if($columnname !=$this->primaryKeyColumnName) {      // hodnota primárního klíče se nenačítá - nikdy se nedělá UPDATE vždy jen INSERT
                        $this->values[$columnid] = $data[$columnname];
                    }
                }
                $this->isHydrated = TRUE;
            }
        }
        return $this;
    }
    
    public function getTableName() {
        return $this->tableName;
    }
    
    public function getPrimaryKeyColumnName() {
        return $this->primaryKeyColumnName;
    }
    
    public function getNames() {
        return $this->names;
    }
    
    public function getValues() {
        $this->read();        
        return $this->values;
    }
    
    /**
     * Metoda vrací asociativní pole hodnot indexované názvy sloupců (vlastností objektu)
     * @return array
     */
    public function getValuesAssoc() {
        $this->read();
        $assoc_value = array();
        foreach($this->names as $columnid => $columnname) {
            $assoc_value[$columnname] = $this->values[$columnid];
        }
        return $assoc_value;
    }
}