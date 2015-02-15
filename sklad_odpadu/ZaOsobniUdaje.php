<?php
class Projektor2_Model_Flat_ZaOsobniUdaje {
    // tabulka uc_osobni_udaje
    public $zajemce;
    public $id;
    public $jmeno;
    public $prijmeni;
    public $rodne_cislo;
    public $datum_narozeni;
    public $datum_vstupu;
    public $datum_vystupu;
    public $id_c_pohlavi;
    public $id_c_titul_pred;
    public $id_c_titul_za;
    public $id_c_duvod_vystupu;
    public $chyby;
    
    public function __construct( $zajemce,$id = false,$jmeno = false,$prijmeni = false,$rodne_cislo = false,$datum_narozeni = false,$datum_vstupu = false,$datum_vystupu = false,$id_c_pohlavi = false,$id_c_titul_pred = "NULL",$id_c_titul_za = "NULL",$id_c_duvod_vystupu="NULL") {
        $this->zajemce = $zajemce;
        $this->id = $id;
        $this->jmeno = $jmeno;
        $this->prijmeni = $prijmeni;
        $this->rodne_cislo = $rodne_cislo;
        //$this->rodne_cislo = new rodne_cislo($rodne_cislo);
        $this->datum_narozeni = new Projektor2_Datum($datum_narozeni);
        $this->datum_vstupu = new Projektor2_Datum($datum_vstupu);
        $this->datum_vystupu = new Projektor2_Datum($datum_vystupu);
        $this->id_c_pohlavi = $id_c_pohlavi;
        $this->id_c_titul_pred = $id_c_titul_pred;
        $this->id_c_titul_za = $id_c_titul_za;
        $this->id_c_duvod_vystupu = $id_c_duvod_vystupu;
        $this->chyby = new Projektor2_Chyby;
        
    }
    
    public function get_values() {
        if($this->zajemce->id) {
            $dbh=Projektor2_AppContext::getDb();
            $query="SELECT  id_uc_osobni_udaje,
                            jmeno,
                            prijmeni,
                            datum_narozeni,
                            rodne_cislo,
                            datum_vstupu,
                            datum_vystupu,
                            id_c_pohlavi_FK,
                            id_c_titul_pred_FK,
                            id_c_titul_za_FK
                    FROM uc_osobni_udaje
                    WHERE id_ucastnik_FK = :1";
            $data=$dbh->prepare($query)->execute($this->zajemce->id)->fetch();
            if($data) {
                $this->id=$data['id_uc_osobni_udaje'];
                $this->jmeno=$data['jmeno'];
                $this->prijmeni=$data['prijmeni'];
                $this->rodne_cislo=$data['rodne_cislo'];
                $this->datum_narozeni = new Projektor2_Datum($data['datum_narozeni'],"MySQL");
                $this->datum_vstupu = new Projektor2_Datum($data['datum_vstupu'],"MySQL");
                $this->datum_vystupu = new Projektor2_Datum($data['datum_vystupu'],"MySQL");
                $this->id_c_pohlavi = $data['id_c_pohlavi_FK'];
                $this->id_c_titul_pred = $data['id_c_titul_pred_FK'];
                $this->id_c_titul_za = $data['id_c_titul_za_FK'];
            }
        }
    }
    
    
    
   
    
    
    public function check_values() {
//        echo "\n----Overuji uc_osobni_udaje*\n";	//	klon
//        print_r($this);
//        echo "\n*----------------------------\n";
        
        //Overeni rozsahu
        // - Overeni datumy
        $datumy = array("datum_narozeni");
        foreach($datumy as $datum) {
            
            
            if($this->$datum) {
                if(!$this->$datum->ok){
                    $this->chyby->write($datum,$this->$datum,305);
                } else {
                    if(!$this->$datum->notNull){
                        $this->chyby->write($datum,$this->$datum,503);
                    }
                }
            }
        }
        // - Overeni ciselniku
        $pole_ciselniku=array("c_pohlavi","c_titul_pred","c_titul_za","c_duvod_vystupu");
        Foreach($pole_ciselniku as $ciselnik_jmeno) {
            $ciselnik_nazev_PK = "id_".$ciselnik_jmeno;
            if($this->$ciselnik_nazev_PK) {
                $kontrolovany_ciselnik = new Projektor2_Model_Db_Ciselnik($ciselnik_jmeno);
                if(!$kontrolovany_ciselnik->check_id($this->$ciselnik_nazev_PK)) {
                    $this->chyby->write($ciselnik_jmeno,$this->$ciselnik_nazev_PK,401);
                }
            }
            else {
                $this->$ciselnik_nazev_PK="NULL";
            }
        }
        
        // - Overeni rodne cislo
//        if(!$this->rodne_cislo->ok) {
//            $this->chyby->write("rodne_cislo",$this->rodne_cislo,501);
//        }

        //Overeni povinné údaje
            //Prijmeni
            if(strlen($this->prijmeni) < 1) {
                $this->chyby->write("prijmeni",$this->prijmeni,503);
            }
            //Prijmeni
            if(strlen($this->jmeno) < 1) {
                $this->chyby->write("jmeno",$this->jmeno,503);
            }
            //Pohlavi
            if($this->id_c_pohlavi=="NULL") {
                $this->chyby->write("pohlavi",$this->id_c_pohlavi,503);
            }
      //  echo "<BR> strlen(this->jmeno) " . strlen($this->jmeno);
      //  echo "<BR> this->chyby <BR>";
      //  print_r($this->chyby);
        return $this->chyby;
    }
    
    public function save_values() {
        if(!$this->zajemce->id){
            throw new Exception("ucastnik hasn't seted his ID,cann't save vaules into table uc_osobni_udaje");
        }
        if($this->chyby->pocet!=0) {
            throw new Exception("There is some errors detected (in uc_osobni_udaje), cann't save values-".print_r($this->chyby).print_r($this->zajemce));
        }
        $query="INSERT INTO uc_osobni_udaje(jmeno,prijmeni,datum_narozeni,rodne_cislo,datum_vstupu,datum_vystupu,id_ucastnik_FK,id_c_pohlavi_FK,id_c_titul_pred_FK,id_c_titul_za_FK,id_c_duvod_vystupu_FK)
                VALUES (:1,:2,:3,:4,:5,:6,:7,:8,:9,:10,:11)";
        $dbh = Projektor2_AppContext::getDb();
        $dbh->prepare($query)->execute($this->jmeno,$this->prijmeni,$this->datum_narozeni->f_mysql,$this->rodne_cislo,$this->datum_vstupu->f_mysql,$this->datum_vystupu->f_mysql,$this->zajemce->id,
        $this->id_c_pohlavi,$this->id_c_titul_pred,$this->id_c_titul_za,$this->id_c_duvod_vystupu);
        $query="SELECT last_insert_id()";
        list($this->id) = $dbh->prepare($query)->execute()->fetch_row();
    }
    public function update_values() {
        if(!$this->zajemce->id){
            throw new Exception("ucastnik hasn't seted his ID,cann't save vaules into table uc_osobni_udaje");
        }
        if($this->chyby->pocet!=0) {
            throw new Exception("There is some errors detected, cann't save values");
        }
        $query="UPDATE uc_osobni_udaje SET jmeno = :1,prijmeni = :2, datum_narozeni = :3, rodne_cislo = :4, datum_vstupu = :5,datum_vystupu = :6,
                id_c_pohlavi_FK = :8, id_c_titul_pred_FK = :9, id_c_titul_za_FK = :10, id_c_duvod_vystupu_FK = :11 
                WHERE id_ucastnik_FK = :7;";
                
        $dbh = Projektor2_AppContext::getDb();
        $dbh->prepare($query)->execute($this->jmeno,$this->prijmeni,$this->datum_narozeni->f_mysql,$this->rodne_cislo,$this->datum_vstupu->f_mysql,$this->datum_vystupu->f_mysql,$this->zajemce->id,
        $this->id_c_pohlavi,$this->id_c_titul_pred,$this->id_c_titul_za,$this->id_c_duvod_vystupu);
        
    }
}
?>