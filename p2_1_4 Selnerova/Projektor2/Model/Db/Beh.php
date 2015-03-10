<?php
class Projektor2_Model_Db_Beh {
    public $id;
    public $beh_cislo;
    public $oznaceni_turnusu;
    public $id_c_projekt;
    public $text;
    public $zacatek;
    public $konec;
    public $closed;
    
    public function __construct($id=false,$beh_cislo=false, $oznaceni_turnusu=false,
                                $text=false,$zacatek=false,$konec=false,$closed=false) {
        $this->id = $id;
        $this->beh_cislo = $beh_cislo;
        $this->oznaceni_turnusu = $oznaceni_turnusu;
        $this->text = $text;
        $this->zacatek = $zacatek;
        $this->konec = $konec;
        $this->closed = $closed;
    }
}

?>