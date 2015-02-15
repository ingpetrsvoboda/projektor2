<?php
class Projektor2_Model_Db_Flat_UcFlatTable extends Framework_Model_ItemFlatTable {
    
    public function __construct(Projektor2_Model_Db_Ucastnik $ucastnik){
        parent::__construct("uc_flat_table",$ucastnik);
        }
}
?>