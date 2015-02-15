<?php
class Projektor2_Model_ZajemceRegistrace {
    //tabulka zajemce
    CONST TABLE = "zajemce";
    public $id;
    public $jmeno_cele;
    public $identifikator;
    public $znacka;

    private  $skupiny = array();
    
    public function __construct($jmeno_cele=NULL, $identifikator=NULL, $znacka=NULL, $id=NULL) {
        $this->id = $id;
        $this->jmeno_cele = $jmeno_cele;
        $this->identifikator = $identifikator;
        $this->znacka = $znacka;
    }
    
    public function setSkupina($name, Projektor2_Model_Menu_Skupina $skupina) {
        $this->skupiny[$name] = $skupina;
    }
    
    /**
     * 
     * @param string $name
     * @return Projektor2_Model_Menu_Skupina
     */
    public function getSkupina($name) {
        return $this->skupiny[$name];
    }
    
    public function getSkupinyAssoc() {
        return $this->skupiny;
    }    
}
?>
