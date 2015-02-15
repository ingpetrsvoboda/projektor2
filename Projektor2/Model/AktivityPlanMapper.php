<?php
/**
 * Description of Projektor2_Model_KurzPlanMapper
 *
 * @author pes2704
 */
class Projektor2_Model_AktivityPlanMapper {
    
    public static function findByIndexAktivity(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $indexAktivity) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);
        $kurzPlan = NULL;
        if ($plan AND $aktivity) {
            $id = 0;
            $aktivita = $aktivity[$indexAktivity];
            $id++;
            $kurzPlan = self::createItem($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);         
        }
        return $kurzPlan;
    }
    
    public static function findAll(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);        
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);  
        $kolekce = array();
        if ($plan AND $aktivity) {
            $id = 0;
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $item = self::createItem($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
                if ($item) {
                    $id++;
                    $kolekce[] = $item;
                }
            }
        } else {
            $kolekce = array();
        }
        return $kolekce;
    }
    
    public static function findAllAssoc(Projektor2_Model_SessionStatus $sessionStatus, Projektor2_Model_Db_Zajemce $zajemce, $typAktivity=NULL) {
        $plan = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce);
        $aktivity = Projektor2_AppContext::getAktivityProjektu($sessionStatus->projekt->kod);  
        if ($plan AND $aktivity) {
            $id = 0;
            foreach ($aktivity as $indexAktivity=>$aktivita) {
                $item = self::createItem($plan, $ukonceni, $aktivita, $indexAktivity, $id, $zajemce);
                if ($item) {
                    $id++;
                    $kolekce[$indexAktivity] = $item;
                }                
            }
        } else {
            $kolekce = array();
        }
        return $kolekce;
    }    

    
    private static function createItem(Projektor2_Model_Db_Flat_ZaPlanFlatTable $plan, Projektor2_Model_Db_Flat_ZaUkoncFlatTable $ukonceni, 
            $aktivita, $indexAktivity, $id, $zajemce) {
        if ($aktivita['typ']=='kurz') {
            $columnsPlan = $plan->getItemColumnsNames($indexAktivity);
            $columnsUkonceni = $ukonceni->getItemColumnsNames($indexAktivity);
            $sKurz = Projektor2_Model_Db_SKurzMapper::findById($plan->$columnsPlan['idSKurzFK']);
            if ($sKurz) {
                $certifikatKurz = Projektor2_Model_Db_CertifikatKurzMapper::findByZajemceKurz($zajemce, $sKurz);
            } else {
                $certifikatKurz = NULL;
            }
            return new Projektor2_Model_AktivitaPlan($id, $indexAktivity, $aktivita['nadpis'], $aktivita['s_certifikatem'], 
                    $sKurz, 
                    $plan->$columnsPlan['pocAbsHodin'], $plan->$columnsPlan['duvodAbsence'], $plan->$columnsPlan['dokonceno'], 
                    $plan->$columnsPlan['duvodNeukonceni'], $plan->$columnsPlan['datumCertif'],
                    $certifikatKurz,
                    $ukonceni->$columnsUkonceni['hodnoceni']);         
        }            
    }
    //ZBYTKY!!
    
    /**
     * Metoda vytváří pole s názvy sloupců, které obsahují údaje o kurzech ve flat table plan. K tomu používá 
     * aktivity projektu načtené z AppContext, vrací tedy pouze kurzy pro projekt.
     * Indexy pole odpovídají sloupci kurz_druh v tabulce s_kurz (velká písmena) a každý prvek pole obsahuje pole s názvy 
     * sloupců flat table plan odpovídajícími danému kurzu.
     * Položky pole vytváří pouze pro kurzy (aktivity typu kurz).
     */
    public function getKurzyColumnNames($projektKod) {
        $aktivity = Projektor2_AppContext::getAktivityProjektu($projektKod);  
        foreach ($aktivity as $indexAktivity=>$aktivita) {
            if ($aktivita['typ']=='kurz') {
                $kurzy[$aktivita['kurz_druh']] = $this->getItemColumnsNames($indexAktivity);
            }
        }
        return $kurzy;
    }
    
    /**
     * Metoda vytváří pole s názvy sloupců, které obsahují údaje o kurzech ve flat table plan. K tomu používá 
     * aktivity projektu načtené z AppContext, vrací tedy pouze kurzy pro projekt.
     * Indexy pole odpovídají sloupci kurz_druh v tabulce s_kurz (velká písmena) a každý prvek pole obsahuje pole s názvy 
     * sloupců flat table plan odpovídajícími danému kurzu
     * Položky pole vytváří pouze pro kurzy (aktivity typu kurz), které jsou zakončeny certifikátem.
     */
    public function getCertifKurzyColumnNames($projektKod) {
        $aktivity = Projektor2_AppContext::getAktivityProjektu($projektKod);  
        foreach ($aktivity as $indexAktivity=>$aktivita) {
            if ($aktivita['typ']=='kurz' AND $aktivita['s_certifikatem']) {
                $kurzy[$aktivita['kurz_druh']] = $this->getItemColumnsNames($indexAktivity);
            }
        }
        return $kurzy;
    }
    
    public function getKurzColumnNames($projektKod, $kurzDruh) {
        $aktivity = Projektor2_AppContext::getAktivityProjektu($projektKod);  
        foreach ($aktivity as $indexAktivity => $aktivita) {
            if ($aktivita['kurz_druh']==$kurzDruh) {
                return $this->getItemColumnsNames($indexAktivity);
            }
        }
        return NULL;
    }
}
