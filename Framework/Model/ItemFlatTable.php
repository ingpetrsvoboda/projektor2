<?php
/**
 * verze 2.1 - je potomkem Framework_Model_ItemAbstract nikoli Persistable Item
 */
abstract class Framework_Model_ItemFlatTable extends Framework_Model_DbItemAbstract {
    protected $tableName;
    protected $mainObjectIdColumnName;
    protected $id;
    protected $mainObject;
    protected $mainObjectClassName;
    protected $isCreatedNewMainObject;
    protected $idColumnName;
    protected $mainObjectMapperClassName;

    protected $dbh;
    protected $attributes;
    protected $changed;
    protected $primaryKeyColumnName;
    
    private $isHydrated;
    private $isPersisted;

    /**
     * Konstruktor přetěžuje rodičovský konstruktor. Musí být volán s parametrem $mainObject nebo (pro nově vytvářený main object) 
     * s parametrem $mainObject=NULL a s nastaveným parametrem $mainObjectMapperClassName
     * @param string $tableName Název db tabulky
     * @param string $mainObject
     * @param string $idColumnName Název sloupce s primárním klíčem db tabulky $table_name. Pokud parametr není zadán, 
     *          metoda použije default hodnotu složenou z prefixu 'id_' a názvu tabulky (např. pro název tabulky 'osoba' použije !id_osoba'
     * @param string $mainObjectMapperClassName Název třídy mapperu, který vytvoří nový main object k pravě vytvářenímu objektu flat table
     * @throws UnexpectedValueException
     */
    public function __construct($tableName, $mainObject=null, $idColumnName=NULL, $mainObjectMapperClassName=NULL) {          
        $this->tableName = $tableName;
        $this->idColumnName = $idColumnName;
        if ($mainObject) {
            $this->initializeMainObject($mainObject);
            $this->isCreatedNewMainObject = FALSE;
        } else {
            if (!$mainObjectMapperClassName) {
                throw new UnexpectedValueException('Není zadán hlavní objekt a není zadán ani mapper pro jeho vytvoření.');
            } else {
                $this->mainObjectMapperClassName = $mainObjectMapperClassName;
            }
        }
        $this->dbh = Projektor2_AppContext::getDb();
        // jedno načtení trvá cca 10ms, bez cache se jedna struktuta (struktura jedné tabulky) čte průměrně 5x
//        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
//        $query = "SHOW COLUMNS FROM ".$this->tableName;
//        $sth = $this->dbh->prepare($query);
//        $succ = $sth->execute();
//        $columnsInfo = $sth->fetchAll(PDO::FETCH_ASSOC);         
//        foreach($columnsInfo as $columnInfo) {
//            $this->attributes[$columnInfo['Field']] = $columnInfo['Default'];
//            if ($columnInfo['Key']=="PRI") $this->primaryKeyColumnName = $columnInfo['Field'];        
//        }
        $this->attributes = Framework_Database_Cache::getAttributes($this->dbh, $this->tableName);
        $this->primaryKeyColumnName = Framework_Database_Cache::getPrimaryKeyName($this->dbh, $this->tableName);
    }

    private function initializeMainObject($mainObject) {
        $this->mainObject = $mainObject;
        $mainObjectClassName = get_class($mainObject);  //proměnná jen kvůli syntaxi $mainObjectClassName::TABLE
        $this->mainObjectClassName = $mainObjectClassName;
        if ($this->idColumnName){
            $this->mainObjectIdColumnName = $this->idColumnName;
        } elseif ($mainObjectClassName::TABLE) {
            $this->mainObjectIdColumnName = 'id_'.$mainObjectClassName::TABLE;
            } else {
                throw new LogicException("Nelze vytvořit default název primárního klíče flat table. Parametr konstruktoru \$idColumnName nebyl nastaven a hlavní objekt $this->mainObjectClassName nemá konstantu TABLE, ze které lze odvodit default hodnotu." );
            }        
    }
    
    private function createNewMainObject() {
        $mapperClassName = $this->mainObjectMapperClassName;
        $mainObject = $mapperClassName::create();
        $this->initializeMainObject($mainObject);
        $this->isCreatedNewMainObject = TRUE;
    }
    
    /**
     * Getter, vrací jen existující vlastnosti.
     * @param type $name
     * @return type
     */
    public function __get($name){
        $this->hydrate();
        if ($this->getIterator()->offsetExists($name)) {
            return $this->attributes[$name];
        }
    }
    
    /**
     * Setter, přetěžuje setter rodiče. Nastavuje jen hodnoty existujících vlastností, nepřidává další vlastnosti. 
     * V případě, že $name neodpovídá existující vlastnosti metoda jen tiše skončí. Jedinou výjimkou je pokus o nastevení vlastnosti 
     * odpovídající id objektu, v takovém případě metoda vyhodí výjimku.
     * @param type $name
     * @param type $value
     * @return mixed
     * @throws UnexpectedValueException
     */
    public function __set($name,$value){
        $this->hydrate();
        if ($name == $this->primaryKeyColumnName) {
            throw new UnexpectedValueException("nelze nastavovat vlastnost $name odpovídající primárnímu klíči tabulky $this->tableName");
        }
        if ($this->getIterator()->offsetExists($name)) {        
            $this->attributes[$name] = $value;
            $this->changed[$name] = $value;
            return $value;
        }
    }
    
    public function persist() {
        assert(FALSE, 'Metoda '.__METHOD__.' není implementována.');
        return parent::persist(new Framework_Model_FlatTableMapper());
    }  
    
    private function hydrate() {
        if (!$this->isHydrated) {
            if(!$this->mainObject->id){
                return $this;
//                throw new LogicException("Neexistuje hlavní objekt nebo hlavní objekt nemá id, nemohu načíst data z tabulky $this->tableName");
            } else {
                $whereParams = array($this->mainObjectIdColumnName=>$this->mainObject->id);
                $query = 'SELECT '.implode(', ', array_keys($this->attributes)).' FROM '.$this->tableName.$this->createWhereExpression($whereParams);                
                $sth = $this->dbh->prepare($query);
                $succ = $sth->execute($whereParams);
                if ($succ) {
                    $data = $sth->fetch(PDO::FETCH_ASSOC);  
                    if($data) {
                        foreach ($data as $key => $value) {  //$this->attributes = $data;
                            $this->attributes[$key] = $value;
                        }
                        $this->id = $this->attributes[$this->primaryKeyColumnName];
                        $this->isHydrated = TRUE;
                        $this->isPersisted = TRUE;
                    } else {
                        $this->isHydrated = TRUE;
                        $this->isPersisted = FALSE;                        
                    }
                }
            }
        }
        return $this;
    }
    
    /**
     * 
     * @return \Framework_Model_ItemFlatTable
     * @throws LogicException
     * @throws UnexpectedValueException
     */
    public function save() {
        if(!$this->mainObject->id){
            $this->createNewMainObject();
            if(!$this->mainObject->id){
                throw new LogicException("Při pokusu o uložení flat table bez hlavního objektu se nepodařilo vytvořit nový hlavní objekt flat table nebo hlavní objekt $this->mainObjectClassName nemá id, nemohu ukládat podřízený objekt do ".$this->tableName);
            }            
        }
        if (!array_key_exists($this->mainObjectIdColumnName, $this->attributes)) {
            throw new UnexpectedValueException("Nenalezen očekávaný sloupec s názvem $this->mainObjectIdColumnName v tabulce $this->tableName");
        }
        if ($this->isPersisted) {
            $this->update();
        } else {
            $this->insert();
        }
        return $this;        
    }

    /**
     * 
     * @throws RuntimeException
     */
    private function update() {
        if ($this->changed) {
            $set = array();
            foreach ($this->changed as $col => $value) {
                    $set[] = $col . " = :" . $col;                    
            }
            $whereParams = array($this->primaryKeyColumnName=>$this->attributes[$this->primaryKeyColumnName]);
            $query = "UPDATE ".  $this->tableName." SET ".implode(", ", $set).$this->createWhereExpression($whereParams);
            $sth = $this->dbh->prepare($query);
            $succ = $sth->execute(array_merge($this->changed, $whereParams));
            if (!$succ) {
                throw new RuntimeException("Nepodařilo se provést příkaz $query.");
            }
            $this->changed = array();
        }        
    }

    /**
     * 
     * @throws RuntimeException
     */
    private function insert() {
        if ($this->changed) {
            $this->attributes[$this->mainObjectIdColumnName] = $this->mainObject->id;
            $this->changed[$this->mainObjectIdColumnName] = $this->mainObject->id;
        
            $cols = implode(', ', array_keys($this->changed));
            $values = ':'.implode(', :', array_keys($this->changed));
            $query = "INSERT INTO ".$this->tableName." (".$cols.")  VALUES (" .$values.")";   
            $sth = $this->dbh->prepare($query);
            $succ = $sth->execute($this->changed);
            if (!$succ) {
                throw new RuntimeException("Nepodařilo se provést příkaz $query.");
            }
            $this->id = $this->dbh->lastInsertId();
            $this->attributes[$this->primaryKeyColumnName] = $this->id;
            $this->changed = array();
            $this->isPersisted = TRUE;
        }
    }    
    
    private function createWhereExpression($whereBind, $boolOperator = "AND") {
        if($whereBind) {
            $whereConditions = array();
            foreach (array_keys($whereBind) as $col) {
                $whereConditions[] = $col . " = :" . $col;
            }
            $expr = ' WHERE '.implode(" ".$boolOperator." ", $whereConditions);
        }
        return $expr;        
    }    

    public function getMainObject() {
        return $this->mainObject;
    }
    
    public function isCreatedNewMainObject() {
        return $this->isCreatedNewMainObject;
    }
    
    public function getTableName() {
        return $this->tableName;
    }
    
    public function getPrimaryKeyColumnName() {
        return $this->primaryKeyColumnName;
    }
    
    /**
     * Metoda vrací iterátor obsahující public vlastnosti objektu. Přetěžuje metodu rodiče.
     * @return \ArrayIterator
     */
    public function getIterator() {
        if ($this->isPersisted !== FALSE) {
            $this->hydrate();
        } 
        return new ArrayIterator($this->attributes); 
    }
}