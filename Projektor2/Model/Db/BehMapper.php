<?php
class Projektor2_Model_Db_BehMapper {
    public static function findById($id, $findInvalid=FALSE, $findOutOfContext=FALSE) {
        $dbh = Projektor2_AppContext::getDb();
        $appStatus = Projektor2_Model_SessionStatus::getSessionStatus();        
        $query = "SELECT * FROM s_beh_projektu"
                . " WHERE id_s_beh_projektu = :id_s_beh_projektu";
        $bindParams = array('id_s_beh_projektu'=>$id);
        if (!$findOutOfContext) {
            $query .= " AND id_c_projekt = :id_c_projekt";
            $bindParams = array_merge($bindParams, array(
                            'id_c_projekt'=>isset($appStatus->projekt) ? $appStatus->projekt->id : NULL));
        }
        if (!$findInvalid) {
            $query .=  " AND valid = 1";
        }
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radek = $sth->fetch(PDO::FETCH_ASSOC); 
        return self::createModel($radek);
    }

    /**
     * vždy vybírá běhy jen pro aktuální projekt
     * @param type $filter
     * @param type $order
     * @return type
     */
    public static function findAll($filter = NULL, $order = NULL, $findInvalid=FALSE) {
        $dbh = Projektor2_AppContext::getDb(); 
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();    
        // vždy vybírá běhy jen pro aktuální projekt        
        $query = "SELECT * FROM s_beh_projektu WHERE id_c_projekt = :id_c_projekt";
        if (!$findInvalid) {
            $query .=  " AND valid = 1";
        }
        if ($filter AND is_string($filter)) {
            $query .= " AND ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        
        $bindParams = array('id_c_projekt'=>$sessionStatus->projekt->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return array();
        }        
        foreach($radky as $radek) {
            $vypis[] = self::createModel($radek);
        }
        return $vypis;        
    }
    
    private static function createModel($radek=NULL) {
        if(!$radek) {
            return NULL;
        }
        $datetimeZacatek = Projektor2_Date::createFromSqlDate($radek['zacatek']);
        if ($datetimeZacatek) {
            $zacatek = $datetimeZacatek->getCzechStringDate();                
        } else {
            $zacatek = '';
        }
        $datetimeKonec = Projektor2_Date::createFromSqlDate($radek['konec']);
        if ($datetimeKonec) {
            $konec = $datetimeKonec->getCzechStringDate();
        } else {
            $konec = '';
        }
        return new Projektor2_Model_Db_Beh($radek['id_s_beh_projektu'],$radek['beh_cislo'],$radek['oznaceni_turnusu'],$radek['text'],$zacatek,$konec,$radek['closed']);
    }
}

?>