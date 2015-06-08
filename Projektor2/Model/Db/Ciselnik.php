<?php
abstract class Projektor2_Model_Db_CiselnikAbstract {
    //tabulka číselníku má vždy (minimálně) tyto sloupce
    public $id;
    public $razeni;
    public $kod;
    public $text;
    public $plny_text;
    public $valid;
    
    public function __construct($id = false, $razeni=false, $kod = false,$text = false,$plny_text = false,$valid = true) {
        $this->id = $id;
        $this->razeni = $razeni;
        $this->kod = $kod;
        $this->text = $text;
        $this->plny_text = $plny_text;
        $this->valid = $valid;
    }
}
