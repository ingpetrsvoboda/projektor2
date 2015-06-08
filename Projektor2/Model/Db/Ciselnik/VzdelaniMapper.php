<?php
/**
 * Description of Projektor2_Model_Db_Ciselnik_VzdelavaniMapper
 *
 * @author pes2704
 */
class Projektor2_Model_Db_Ciselnik_VzdelaniMapper extends Projektor2_Model_Db_CiselnikMapperAbstract {
    const TABLE = 'c_vzdelani';
    
    protected static function createModel($radek) {
        if(!$radek) {
            return NULL;
        } 
        return new Projektor2_Model_Db_Ciselnik_Vzdelani($data['id_c_vzdelani'], $data['razeni'], $data['kod'], $data['text'], $data['plny_text'], $data['valid']);
    }      
}
