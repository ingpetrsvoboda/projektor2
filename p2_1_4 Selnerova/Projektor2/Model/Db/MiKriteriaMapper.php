<?php
class Projektor2_Model_Db_MiKriterieMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM mi_kriteria WHERE id_mi_kriteria = :id_mi_kriteria AND valid = 1";
        $bindParams = array('id_mi_kriteria'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        $datetimeMonitoringu = Projektor2_Date::zSQL($radek['date_monitoringu']);
        if ($datetimeMonitoringu) {
            $datumMonitoringu = $datetimeZacatek->dejDatumRetezec();                
        } else {
            $datumMonitoringu = '';
        }
        return new Projektor2_Model_Db_MiKriteria($data['id_mi_kriteria'],$datumMonitoringu,$data['kod_projektu'],$data['kumulativne'],$data['valid']);
    }

    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = "SELECT * FROM mi_kriteria WHERE valid = 1";
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
            $datetimeMonitoringu = Projektor2_Date::zSQL($radek['date_monitoringu']);
            if ($datetimeMonitoringu) {
                $datumMonitoringu = $datetimeZacatek->dejDatumRetezec();                
            } else {
                $datumMonitoringu = '';
            }
            $vypis[] = new Projektor2_Model_Db_Beh($data['id_mi_kriteria'],$datumMonitoringu,$data['kod_projektu'],$data['kumulativne'],$data['valid']);
        }
        return $vypis;        
    }
}

?>