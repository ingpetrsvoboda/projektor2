<?php
class Projektor2_Model_Db_CertifikatKurz {
    //tabulka zajemce
    CONST TABLE = "certifikat_kurz";
    public $id;
    public $id_zajemce_FK;
    public $id_s_kurz_FK;
    public $cislo;
    public $rok;
    public $identifikator;
    public $filename;
    public $date;
    public $creating_time;
    public $creator;
    public $service;
    public $db_host;


    public function __construct($id_zajemce_FK, $id_s_kurz_FK, $cislo, $rok, $identifikator, $filename, $date, $creating_time, $creator, $service, $db_host, $id=false) {
        $this->id = $id;
        $this->id_zajemce_FK = $id_zajemce_FK;
        $this->id_s_kurz_FK = $id_s_kurz_FK;
        $this->cislo = $cislo;
        $this->rok = $rok;
        $this->identifikator = $identifikator;
        $this->filename = $filename;
        $this->date = $date;
        $this->creating_time = $creating_time;
        $this->creator = $creator;
        $this->service = $service;
        $this->db_host = $db_host;
    }
   
}
?>
