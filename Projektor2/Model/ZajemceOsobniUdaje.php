<?php
class Projektor2_Model_ZajemceOsobniUdaje {
    public $id;
    /**
     * @var Projektor2_Model_Db_Zajemce 
     */
    public $zajemce;
    public $jmeno;
    public $prijmeni;
    public $rodne_cislo;
    public $datum_narozeni;
    public $pohlavi;
    public $titul;
    public $titul_za;
    
    public function __construct($id = NULL, Projektor2_Model_Db_Zajemce $zajemce=NULL,
                            $jmeno = NULL, $prijmeni = NULL, $rodne_cislo = NULL, $datum_narozeni = NULL,
                            $pohlavi = NULL, $titul = NULL, $titul_za = NULL) {
        $this->id = $id;
        $this->zajemce = $zajemce;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->rodne_cislo = $rodne_cislo;
        $this->datum_narozeni = $datum_narozeni;
        $this->pohlavi = $pohlavi;
        $this->titul = $titul;
        $this->titul_za = $titul_za;
    }
    
    /**
     * Vrací celé jméno složené zleva z příjmení, křestního jména, titulu před, titulu za jménem. Tento formát je vhodný pro abecední řazení 
     * podle celého jména.
     * @return string
     */
    public function jmenoCele() {
        return implode(' ', array($this->prijmeni, $this->jmeno, $this->titul, $this->titul_za)); //začíná příjmením 
    }
}
