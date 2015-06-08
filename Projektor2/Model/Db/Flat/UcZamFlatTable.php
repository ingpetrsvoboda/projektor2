<?php
class Projektor2_Model_Db_Flat_UcZamFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Ucastnik $ucastnik){
        parent::__construct("uc_zam_flat_table",$ucastnik);
        }
}
?>