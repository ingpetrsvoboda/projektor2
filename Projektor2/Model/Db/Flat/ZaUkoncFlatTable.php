<?php
class Projektor2_Model_Db_Flat_ZaUkoncFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_ukonc_flat_table",$zajemce);
    }
    
    public static function getItemColumnsNames($indexAktivity) {
        return array('indexAktivity'=> $indexAktivity, 'znamka'=> $indexAktivity.'_znamka',
            'hodnoceni'=>$indexAktivity.'_hodnoceni');        
    }    
}
?>