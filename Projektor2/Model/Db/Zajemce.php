<?php
class Projektor2_Model_Db_Zajemce extends Framework_Model_DbItemAbstract {
    //tabulka zajemce
    CONST TABLE = "zajemce";
    public $id;
    public $cislo_zajemce;
    public $identifikator;
    public $znacka;
    public $id_c_projekt_FK;
    public $id_c_kancelar_FK;
    public $id_s_beh_projektu_FK;
    
    public function __construct($cisloZajemce, $identifikator, $znacka, $projektId, $kancelarId, $behId, $id=false) {
        $this->id = $id;
        $this->cislo_zajemce = $cisloZajemce;
        $this->identifikator = $identifikator;
        $this->znacka = $znacka;
        $this->id_c_projekt_FK = $projektId;
        $this->id_c_kancelar_FK = $kancelarId;
        $this->id_s_beh_projektu_FK = $behId;
    }
   
}
?>
