<?php
class Projektor2_Model_Db_Flat_UcTestPCFlatTable extends Framework_Model_ItemFlatTable {
    public function __construct(Projektor2_Model_Db_Ucastnik $ucastnik){
        parent::__construct("uc_testpc_flat_table",$ucastnik);
        }
        
        
        
        
    /***sss***/
    /*
      public function save_values() {
        if(!$this->context->id){
            throw new Exception("flat_table's context hasn't seted his ID,cann't save vaules into table ".$this->table_name);
        }
        if($this->chyby->pocet!=0) {
            throw new Exception("There is some errors detected (in flat table), cann't save values:".print_r($this->chyby));
        }
        $this->id_ucastnik=$this->context->id;
        $dbh = AppContext::getDB();
    
        $query="DELETE FROM ".$this->table_name."
                WHERE id_ucastnik = :1";
                
        $dbh->prepare($query)->execute($this->context->id);
        $query="INSERT INTO ".$this->table_name." (";
        foreach($this->attributs_varname as $varname) {
            //if($varname !="ID") {
                $query.=$varname.",";
           // }
           
           
           
        }
        $query=substr($query,0,strlen($query)-1);
        $query.=") VALUES (";
        foreach($this->attributs_varvalue as $varvalue) {
            if($varvalue) {
                $query.="'".$varvalue."',";
            }
            else {
               // if($varvalue===0) {$query.="0,";}
               // else
               
               
                {$query.="NULL,";}
            }
        }
        $query=substr($query,0,strlen($query)-1);
        $query.=");";
        
        //echo"---------------------------------------";
        //echo $query;
        //echo"---------------------------------------";
        $dbh->prepare($query)->execute("");
        $query="SELECT last_insert_id()";
        list($this->id) = $dbh->prepare($query)->execute()->fetch_row();
    }    
        
    */    
        
        
        
        
}
?>