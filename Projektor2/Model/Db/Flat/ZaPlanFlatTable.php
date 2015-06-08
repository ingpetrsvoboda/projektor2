<?php
/**
 * Používá tabulku za_plan_flat_table
 */
class Projektor2_Model_Db_Flat_ZaPlanFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_plan_flat_table",$zajemce);
    }
    
    /**
     * Vrací asocitivní pole názvů sloupců db tabulky podle zadaného indexu aktivity.
     * @param string $indexAktivity
     * @return array
     */
    public static function getItemColumnsNames($indexAktivity) {
        return array('indexAktivity'=> $indexAktivity, 'idSKurzFK'=> 'id_s_kurz_'.$indexAktivity.'_FK',
            'pocAbsHodin'=>$indexAktivity.'_poc_abs_hodin', 'duvodAbsence'=>$indexAktivity.'_duvod_absence', 
            'dokonceno'=>$indexAktivity.'_dokonceno', 'duvodNeukonceni'=> $indexAktivity.'_duvod_neukonceni', 
            'datumCertif'=> $indexAktivity.'_datum_certif');        
    }
}
?>