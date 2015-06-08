<?php
class Projektor2_Model_Db_Flat_ZaZamFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Zajemce $zajemce){
        parent::__construct("za_zam_flat_table",$zajemce);
        }
}
?>