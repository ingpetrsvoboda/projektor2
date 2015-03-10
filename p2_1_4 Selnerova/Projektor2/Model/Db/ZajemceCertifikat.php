<?php
/**
 * Description of ZajemceCertifikaty
 *
 * @author pes2704
 */
class Projektor2_Model_Db_ZajemceCertifikat {
    public $id;
    public $id_zajemce_FK;
    public $id_s_kurz_FK;
    public $cislo;
    public $rok;
    public $filename;
    public $date;
    public $db_host;
    public $id_s_kurz;
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
    public $dodavatel;
    public $valid;

    public function __construct($id_zajemce_FK, $id_s_kurz_FK, $cislo, $rok, $filename, $date, $db_host, 
            $id_s_kurz, $razeni, $projekt_kod, $kancelar_kod, $kurz_druh, $kurz_cislo, $beh_cislo, $kurz_lokace, $kurz_zkratka, $kurz_nazev, $pocet_hodin, $date_zacatek, $date_konec, $dodavatel, $valid, 
            $id_certifikat_kurz
            ) {
        $this->id = $id_certifikat_kurz;
        $this->id_zajemce_FK = $id_zajemce_FK;
        $this->id_s_kurz_FK = $id_s_kurz_FK;
        $this->cislo = $cislo;
        $this->rok = $rok;
        $this->filename = $filename;
        $this->date = $date;
        $this->db_host = $db_host;
        $this->id_s_kurz = $id_s_kurz;
        $this->razeni = $razeni;
        $this->projekt_kod = $projekt_kod;
        $this->kancelar_kod = $kancelar_kod;
        $this->kurz_druh = $kurz_druh;
        $this->kurz_cislo = $kurz_cislo;
        $this->beh_cislo = $beh_cislo;
        $this->kurz_lokace = $kurz_lokace;
        $this->kurz_zkratka = $kurz_zkratka;
        $this->kurz_nazev = $kurz_zkratka;
        $this->pocet_hodin = $pocet_hodin;
        $this->date_zacatek = $date_zacatek;
        $this->date_konec = $date_konec;
        $this->dodavatel = $dodavatel;
        $this->valid = $valid;
    }

}
