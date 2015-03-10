<?php
class Projektor2_Model_Db_Kancelar {
    //tabulka c_kancelar
    public $id;
    public $id_c_projekt_FK;
    public $razeni;
    public $kod;
    public $text;
    public $plny_text;
    public $valid;
    
    public function __construct($id = false, $id_c_projekt_FK, $razeni=false, $kod = false,$text = false,$plny_text = false,$valid = true) {
        $this->id = $id;
        $this->id_c_projekt_FK = $id_c_projekt_FK;
        $this->razeni = $razeni;
        $this->kod = $kod;
        $this->text = $text;
        $this->plny_text = $plny_text;
        $this->valid = $valid;
    }
}

?>