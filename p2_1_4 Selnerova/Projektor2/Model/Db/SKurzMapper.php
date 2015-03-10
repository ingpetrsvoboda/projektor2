<?php
class Projektor2_Model_Db_SKurzMapper {
    /**
     * 
     * @param integer $id
     * @return \Projektor2_Model_Db_SKurz
     */
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM s_kurz WHERE id_s_kurz = :id_s_kurz AND valid = 1";
        $bindParams = array('id_s_kurz'=>$id);
        
//        $query = "SELECT * FROM s_kurz"
//                . " WHERE id_s_kurz = :id_s_kurz";
//        $bindParams = array('id_s_kurz'=>$id);
//        if (!$findOutOfContext) {
//            $query .= " AND id_c_projekt_FK = :id_c_projekt_FK"
//                    . " AND id_c_kancelar_FK = :id_c_kancelar_FK"
//                    . " AND id_s_beh_projektu_FK = :id_s_beh_projektu_FK";
//            $bindParams = array_merge($bindParams, array(
//                            'id_c_projekt_FK'=>$appStatus->projekt->id, 
//                            'id_c_kancelar_FK'=>$appStatus->kancelar->id, 
//                            'id_s_beh_projektu_FK'=>$appStatus->beh->id));
//        }
//        if (!$findInvalid) {
//            $query .=  " AND valid = 1";
//        }        
        
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radek = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$radek) {
            return NULL;
        } 
        $datetimeZacatek = Projektor2_Date::zSQL($radek['date_zacatek']);
        if ($datetimeZacatek) {
            $dateZacatek = $datetimeZacatek->dejDatumRetezec();                
        } else {
            $dateZacatek = '';
        }
        $datetimeKonec = Projektor2_Date::zSQL($radek['date_konec']);
        if ($datetimeKonec) {
            $dateKonec = $datetimeKonec->dejDatumRetezec();
        } else {
            $dateKonec = '';
        }
        return new Projektor2_Model_Db_SKurz($radek['id_s_kurz'],$radek['razeni'],$radek['projekt_kod'],$radek['kancelar_kod'],
                $radek['kurz_druh'],$radek['kurz_cislo'],$radek['beh_cislo'],$radek['kurz_lokace'],$radek['kurz_zkratka'],
                $radek['kurz_nazev'],$radek['pocet_hodin'],
                $dateZacatek,$dateKonec,$radek['valid']);
    }

    /**
     * 
     * @param type $filter
     * @param type $order
     * @return \Projektor2_Model_Db_SKurz[] array of \Projektor2_Model_Db_SKurz
     */
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = "SELECT * FROM s_kurz WHERE valid = 1";
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return array();
        }
        foreach($radky as $radek) {
            $datetimeZacatek = Projektor2_Date::zSQL($radek['date_zacatek']);
            if ($datetimeZacatek) {
                $dateZacatek = $datetimeZacatek->dejDatumRetezec();                
            } else {
                $dateZacatek = '';
            }
            $datetimeKonec = Projektor2_Date::zSQL($radek['date_konec']);
            if ($datetimeKonec) {
                $dateKonec = $datetimeKonec->dejDatumRetezec();
            } else {
                $dateKonec = '';
            }
            $vypis[] = new Projektor2_Model_Db_SKurz($radek['id_s_kurz'],$radek['razeni'],$radek['projekt_kod'],$radek['kancelar_kod'],
                $radek['kurz_druh'],$radek['kurz_cislo'],$radek['beh_cislo'],$radek['kurz_lokace'],$radek['kurz_zkratka'],
                $radek['kurz_nazev'],$radek['pocet_hodin'],
                $dateZacatek,$dateKonec,$radek['valid']);
        }
        return $vypis;        
    }
}

?>