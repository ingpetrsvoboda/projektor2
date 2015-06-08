<?php
class Projektor2_Model_Db_SKurzMapper {
    /**
     * 
     * @param type $id
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return type
     */
    public static function findById($id, $findInvalid=FALSE) {
        $dbh = Projektor2_AppContext::getDb();
        $query = 'SELECT * FROM s_kurz WHERE id_s_kurz = :id_s_kurz';
        $bindParams = array('id_s_kurz'=>$id); 
        if (!$findInvalid) {
            $query .=  " AND valid = 1";
        }        
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radek = $sth->fetch(PDO::FETCH_ASSOC);  
        return self::createModel($radek);
    }

    /**
     * 
     * @param type $filter
     * @param type $order
     * @return \Projektor2_Model_Db_SKurz[] array of \Projektor2_Model_Db_SKurz
     */
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = 'SELECT * FROM s_kurz WHERE valid = 1';
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
            $vypis[] = self::createModel($radek);
        }
        return $vypis;        
    }
    
    private static function createModel($radek=NULL) {
        if(!$radek) {
            return NULL;
        } 
        $datetimeZacatek = Projektor2_Date::createFromSqlDate($radek['date_zacatek']);
        if ($datetimeZacatek) {
            $dateZacatek = $datetimeZacatek->getCzechStringDate();                
        } else {
            $dateZacatek = '';
        }
        $datetimeKonec = Projektor2_Date::createFromSqlDate($radek['date_konec']);
        if ($datetimeKonec) {
            $dateKonec = $datetimeKonec->getCzechStringDate();
        } else {
            $dateKonec = '';
        }
        return new Projektor2_Model_Db_SKurz($radek['id_s_kurz'],$radek['razeni'],$radek['projekt_kod'],$radek['kancelar_kod'],
                $radek['kurz_druh'],$radek['kurz_cislo'],$radek['beh_cislo'],$radek['kurz_lokace'],$radek['kurz_zkratka'],
                $radek['kurz_nazev'],$radek['pocet_hodin'],
                $dateZacatek,$dateKonec,$radek['valid']);
    }    
}

?>