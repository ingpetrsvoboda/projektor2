<?php
class Projektor2_Model_Db_SKurz {
    public $id;
    public $razeni;
    public $projekt_kod;
    public $kancelar_kod;    
    public $kurz_druh;
    public $kurz_cislo;
    public $beh_cislo;
    public $kurz_lokace;
    public $kurz_zkratka;
    public $kurz_nazev;
    public $pocet_hodin;
    public $date_zacatek;
    public $date_konec;
    public $valid;
    
    public function __construct($id=false, $razeni=false, $projekt_kod=false, $kancelar_kod=false, 
                                $kurz_druh=false, $kurz_cislo=false, $beh_cislo=false, $kurz_lokace=false, $kurz_zkratka=false, 
                                $kurz_nazev=false, $pocet_hodin=false, $date_zacatek=false, $date_konec=false, $valid=false) {
        $this->id = $id;
        $this->razeni = $razeni;
        $this->projekt_kod = $projekt_kod;
        $this->kancelar_kod = $kancelar_kod;
        $this->kurz_druh = $kurz_druh;
        $this->kurz_cislo = $kurz_cislo;
        $this->beh_cislo = $beh_cislo;
        $this->kurz_lokace = $kurz_lokace;
        $this->kurz_zkratka = $kurz_zkratka;
        $this->kurz_nazev = $kurz_nazev;
        $this->pocet_hodin = $pocet_hodin;
        $this->date_zacatek = $date_zacatek;
        $this->date_konec = $date_konec;
        $this->valid = $valid;        
    }
    
    public function isNaplanovan() {
        return $this->kurz_zkratka <> '*';
    }
}

?>