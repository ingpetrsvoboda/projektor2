<?php
class Projektor2_Model_Db_CertifikatKurzMapper {
    
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM certifikat_kurz WHERE id_certifikat_kurz = :id_certifikat_kurz";
        $bindParams = array('id_certifikat_kurz'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_CertifikatKurz($data['id_zajemce_FK'], $data['id_s_kurz_FK'], 
                    $data['cislo'], $data['rok'], $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_kurz']);
    }

    public static function findByZajemceKurz(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM certifikat_kurz WHERE id_zajemce_FK = :id_zajemce_FK AND id_s_kurz_FK = :id_s_kurz_FK";
        $bindParams = array('id_zajemce_FK'=>$zajemce->id, 'id_s_kurz_FK'=>$sKurz->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_CertifikatKurz($data['id_zajemce_FK'], $data['id_s_kurz_FK'], 
                    $data['cislo'], $data['rok'], $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_kurz']);
    }    
    
    /**
     * Vytvoří novy záznam v databázi a zpětně ho načte do nového objektu Projektor2_Model_Certifikat. 
     * Číslo cerifikátu určí jako o jednotku vyšší než nejvyšší číslo již použité v daném roce. 
     * Rok určí automaticky z datutmu za daného parametrem $createDate. 
     * Každému záznamu v databázi metoda sama přidá položku db_host, která obsahuje název hostitele databáze, se kterou aplikace právě pracuje. 
     * Tato požka může sloužit k rozpoznání a odstranění záznamů vzniklých při testování, kdy obvykle db_host=localhost. 
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param Projektor2_Date $date
     * @param string $fileName
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function create(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, 
                                    Projektor2_Date $date, $creator, $service, $fileName=NULL) {
        $rok = $date->getCzechStringYear();

        $dbh = Projektor2_AppContext::getDb(); 

        $query = "SELECT Max(cislo) AS maxCislo  FROM certifikat_kurz WHERE rok=:rok";  //vybírá i nevalidní
        $bindParams = array('rok'=>$rok);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }        
        if ($data['maxCislo']) {
            $cisloCertifikatu= $data['maxCislo'] + 1 ;
        } else {
            $cisloCertifikatu = 1;
        }
        $now = new DateTime("now");
        $modelCertifikatKurz = new Projektor2_Model_Db_CertifikatKurz($zajemce->id, $sKurz->id, 
            $cisloCertifikatu, $rok, Projektor2_AppContext::getCertificateKurzIdentificator($rok, $cisloCertifikatu), 
            $fileName, $date->getSqlDate(), 
            $now->format("Y-m-d H:i:s"), 
            $creator, $service, $dbh->getDbHost());
        // !! creating_time je TIMESTAMP s DEFAULT CURRENT_TIMESTAMP
        foreach ($modelCertifikatKurz as $key => $value) {
            if ($key!='id') {  // vyloučen sloupec PRIMARY KEY 
                $columns[] = $key;
                $values[] = ':'.$key;
                $bindParams[$key] = $value;
            }
        }  
        $query = "INSERT INTO certifikat_kurz (".implode(', ', $columns).")
                  VALUES (".  implode(', ', $values).")";  

//        $bindParams = array('id_zajemce_FK'=>$zajemce->id, 'id_s_kurz_FK'=>$sKurz->id, 
//            'cislo'=>$cisloCertifikatu, 'rok'=>$rok,
//            'identifikator'=>  Projektor2_AppContext::getCertificateKurzIdentificator($rok, $cisloCertifikatu),
//            'filename'=>$fileName, 
//            'date'=>$date->dejDatumproSQL(), 
//            'creator'=>$creator,
//            'service'=>$service,
//            'db_host'=>$dbh->getDbHost());
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        if ($succ) {
            $modelCertifikatKurz->id = $dbh->lastInsertId();
        } else {
            unset($modelCertifikatKurz);
        }
        return $modelCertifikatKurz;
//        $data = $sth->fetch(PDO::FETCH_ASSOC);  
//        // model vytvořen načtením z databáze na základě last insert id
//        return self::findById($dbh->lastInsertId());
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $query = "SELECT * FROM certifikat_kurz";
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        $bindParams = array();
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return array();
        }  
        foreach($radky as $radek) {
            $vypis[] = new Projektor2_Model_Db_CertifikatKurz($data['id_zajemce_FK'], $data['id_s_kurz_FK'], 
                    $data['cislo'], $data['rok'], $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_kurz']);
        }

        return $vypis;
    }
    
    public static function update(Projektor2_Model_Db_CertifikatKurz $kurzCertifikat) {
        $dbh = Projektor2_AppContext::getDb(); 
        foreach ($kurzCertifikat as $key => $value) {
            if ($key!='id') {  // vyloučen sloupec PRIMARY KEY 
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
            }
        }  
        $bindParams['id_certifikat_kurz'] = $kurzCertifikat->id;
        
        $query = "UPDATE certifikat_kurz SET ".implode(', ', $set)." WHERE id_certifikat_kurz=:id_certifikat_kurz";  
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);  
        if ($succ) {
            return $kurzCertifikat;
        } else {
            return NULL;
        }
    }
    
    public static function delete(Projektor2_Model_Db_CertifikatKurz $kurzCertifikat) {
        $dbh = Projektor2_AppContext::getDb(); 

        $query = "DELETE FROM certifikat_kurz WHERE id_certifikat_kurz=:id_certifikat_kurz";  
        $bindParams = array('id_certifikat_kurz'=>$kurzCertifikat->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);  
        if ($succ) {
            unset( $kurzCertifikat);
        }
    }
    
    /**
     * Vytvoří pole (bind) vhodné pro PDO statement execute. Předpokládá, že atribut modelu 'id' odpovídá primárnímu klíči db tabulky
     * a tuto hodnotu vynechá.
     * @param type $model
     */
    private static function bindArray($model) {
 
        return $bindParams;
    }
}

?>