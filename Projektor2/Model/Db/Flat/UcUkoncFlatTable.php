<?php
class Projektor2_Model_Db_Flat_UcUkoncFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Ucastnik $ucastnik){
        parent::__construct("uc_ukonc_flat_table",$ucastnik);
        }
}
?>