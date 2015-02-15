<?php
class Projektor2_Model_Db_ZajemceOsobniUdajeMapper {
    public static function findById($id, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Projektor2_AppContext::getDb();
        $appStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $query = "SELECT zajemce.id_zajemce, zajemce.cislo_zajemce, zajemce.identifikator, zajemce.znacka, 
                        zajemce.id_c_projekt_FK, zajemce.id_c_kancelar_FK, zajemce.id_s_beh_projektu_FK,
                        za_flat_table.jmeno,
                        za_flat_table.prijmeni, za_flat_table.datum_narozeni, za_flat_table.rodne_cislo,
                        za_flat_table.pohlavi, za_flat_table.titul, za_flat_table.titul_za
                    FROM zajemce left join za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)";
        $where[] = "zajemce.id_zajemce = :id_zajemce";
        $bindParams = array('id_zajemce'=>$id);
        if (!$findOutOfContext) {
            if (isset($appStatus->projekt->id)) {
                $where[] = "id_c_projekt_FK = :id_c_projekt_FK";
                $bindParams = array_merge($bindParams, array('id_c_projekt_FK'=>$appStatus->projekt->id));                
            }
            if (isset($appStatus->kancelar->id)) {
                $where[] = "id_c_kancelar_FK = :id_c_kancelar_FK";
                $bindParams = array_merge($bindParams, array('id_c_kancelar_FK'=>$appStatus->kancelar->id));                
            }
            if (isset($appStatus->beh->id)) {
                $where[] = "id_s_beh_projektu_FK = :id_s_beh_projektu_FK";
                $bindParams = array_merge($bindParams, array('id_s_beh_projektu_FK'=>$appStatus->beh->id));                
            }            
        }
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }        
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        $zajemce = new Projektor2_Model_Db_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
        return new Projektor2_Model_Db_ZajemceOsobniUdaje($data['id_zajemce'], $zajemce,
                            $data['jmeno'], $data['prijmeni'], $data['datum_narozeni'], $data['rodne_cislo'],
                            $data['pohlavi'], $data['titul'], $data['titul_za']    );    
    }
    
    public static function findAll($filter = NULL, $filterBindParams=array(), $order = NULL, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Projektor2_AppContext::getDb(); 
        $appStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $query = "SELECT zajemce.id_zajemce, zajemce.cislo_zajemce, zajemce.identifikator, zajemce.znacka, 
                        zajemce.id_c_projekt_FK, zajemce.id_c_kancelar_FK, zajemce.id_s_beh_projektu_FK,
                        za_flat_table.jmeno,
                        za_flat_table.prijmeni, za_flat_table.datum_narozeni, za_flat_table.rodne_cislo,
                        za_flat_table.pohlavi, za_flat_table.titul, za_flat_table.titul_za
                    FROM zajemce left join za_flat_table ON (zajemce.id_zajemce=za_flat_table.id_zajemce)";
        $where = array();
        $bindParams = array();        
        if (!$findOutOfContext) {
            if (isset($appStatus->projekt->id)) {
                $where[] = "id_c_projekt_FK = :id_c_projekt_FK";
                $bindParams = array_merge($bindParams, array('id_c_projekt_FK'=>$appStatus->projekt->id));                
            }
            if (isset($appStatus->kancelar->id)) {
                $where[] = "id_c_kancelar_FK = :id_c_kancelar_FK";
                $bindParams = array_merge($bindParams, array('id_c_kancelar_FK'=>$appStatus->kancelar->id));                
            }
            if (isset($appStatus->beh->id)) {
                $where[] = "id_s_beh_projektu_FK = :id_s_beh_projektu_FK";
                $bindParams = array_merge($bindParams, array('id_s_beh_projektu_FK'=>$appStatus->beh->id));                
            }            
        }
        if (!$findInvalid) {
            $where[] = "valid = 1";
        }        
        if ($filter AND is_string($filter)) {
            $where[] = $filter;
            $bindParams = array_merge($filterBindParams);
        }
        if ($where) {
            $query .= " WHERE ".implode(" AND ", $where);
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }  
        foreach($radky as $data) {
            $zajemce = new Projektor2_Model_Db_Zajemce($data['cislo_zajemce'], $data['identifikator'], $data['znacka'], $data['id_c_projekt_FK'], $data['id_c_kancelar_FK'], $data['id_s_beh_projektu_FK'], $data['id_zajemce']);
            $vypis[] = new Projektor2_Model_Db_ZajemceOsobniUdaje($data['id_zajemce'], $zajemce,
                            $data['jmeno'], $data['prijmeni'], $data['datum_narozeni'], $data['rodne_cislo'],
                            $data['pohlavi'], $data['titul'], $data['titul_za']    );  
        }

        return $vypis;
    }
}