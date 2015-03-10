<?php
class Projektor2_Model_Db_ZaPlanPoradenstviMapper extends Framework_Model_DbMapper {
    
    /**
     * Metoda předepsaná interface. Tato metoda nemá default verzi obsaženou v Base mapperu, musí ji 
     * povinně implementovat každý mapper (konkrétní mapper "zná" svoji databázi)
     * @return string
     */
    public function getDatabaseNick() {
        return 'projektor';
    }
    
    /**
     * Metoda předepsaná interface. Tato metoda nemá default verzi obsaženou v Base mapperu, musí ji 
     * povinně implementovat každý mapper (konkrétní mapper "zná" svoji tabulku).
     * @return string
     */
    public function getTableName() {
        return 'za_plan_poradenstvi';
    }
    
############ METODY PRO VYTVÁŘENÍ OBJEKTŮ ITEM #################################
    
    public function findByIdZajemce($idZajemce) {
        return $this->findOne(array('id_zajemce_FK' =>$idZajemce));
    }   
        
    public function findByIdSKurz($idSKurz) {
        return $this->findOne(array('id_s_kurz_FK' =>$idSKurz));
    }
    
    public function findByIdZajemceAndIdSKurz($idZajemce, $idSKurz) {
        return $this->findOne(array('id_zajemce_FK'=>$idZajemce, 'id_s_kurz_FK'=>$idSKurz));
    } 
}
?>