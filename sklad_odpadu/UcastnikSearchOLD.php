<?php
class Projektor2_Model_UcastnikSearch {
    private $result_ids_array;
    private $cur_index;
    private $Kancelar;
    private $Projekt;
    private $Beh;
    
    public function __construct(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Kancelar $kancelar, Projektor2_Model_Db_Beh $beh) {
        $this->Kancelar = $kancelar;
        $this->Projekt = $projekt;
        $this->Beh = $beh;
        $this->result_ids_array = array();
    }
    public function search_by_jmeno_prijmeni($jmeno,$prijmeni) {
        echo "\n##########Zahaji hledání#######";
        echo " Předané parametry:".$jmeno." ".$prijmeni."\n";
        
        $this->result_ids_array = array();
        $jmeno = trim($jmeno);
        $prijmeni = trim($prijmeni);
        $dbh = Projektor2_AppContext::getDb();
        $query = "  SELECT uc_osobni_udaje.id_ucastnik_FK AS id
                    FROM uc_osobni_udaje Left Join ucastnik
                    ON uc_osobni_udaje.id_ucastnik_FK = ucastnik.id_ucastnik
                    WHERE ucastnik.id_c_kancelar_FK = :3
                    AND ucastnik.id_c_projekt_FK = :4
                    AND ucastnik.id_s_beh_projektu_FK = :5
                    AND uc_osobni_udaje.jmeno LIKE  :1
                    AND uc_osobni_udaje.prijmeni LIKE :2;";
        //echo"\nHledám dotazem:".$query;
        //echo "\n a dosazuji:".$jmeno.";".$prijmeni.";".$this->Kancelar->id.";".$this->Projekt->id."\n\n";
        
        $data = $dbh->prepare($query)->execute($jmeno,$prijmeni,$this->Kancelar->id,$this->Projekt->id,$this->Beh->id);
        echo "\nNalezena id ucastnika:";
        while($zaznam = $data->fetch()) {
            echo $zaznam['id']."\n";
            array_push($this->result_ids_array,$zaznam['id']);
        }
        $this->cur_index = 0;
        if(count($this->result_ids_array)){
            return Projektor2_Model_Db_UcastnikMapper::find_by_id($this->result_ids_array[$this->cur_index]);
        }
        else {
            echo "\n Odpovídám že jsem nic nenašel \n";
            return false;
        }
    }
    public function next(){
        if(++$this->cur_index<count($this->result_ids_array)) {
            return Projektor2_Model_Db_UcastnikMapper::find_by_id($this->result_ids_array[$this->cur_index]);
        }
        else {
            return false;
        }
    }
    public function previous(){
        if(--$this->cur_index>0) {
            return Projektor2_Model_Db_UcastnikMapper::find_by_id($this->result_ids_array[$this->cur_index]);
        }
        else {
            return false;
        }
    }    
    
}

?>