<?php

/*
id_mi_kriteria
date_monitoringu
kod_projektu
kumulativne
 valid
 */

/**
 * Description of MiKriteria
 *
 * @author pes2704
 */
class Projektor2_Model_Db_MiKriteria {

    public $id;
    public $date_monitoringu;
    public $kod_projektu;
    public $kumulativne;
    public $valid;    
    
    public function __construct($id=NULL, $date_monitoringu=NULL, $kod_projektu=NULL, $kumulativne=NULL, $valid=NULL) {
        $this->id = $id;
        $this->date_monitoringu = $date_monitoringu;
        $this->kod_projektu = $kod_projektu;
        $this->kumulativne = $kumulativne;
        $this->valid = $valid;
    }
   
}
