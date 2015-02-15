<?php
class Projektor2_Model_Db_CertifikatProjektMapper {
    
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM certifikat_projekt WHERE id_certifikat_projekt = :id_certifikat_projekt";
        $bindParams = array('id_certifikat_projekt'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_CertifikatProjekt($data['id_zajemce_FK'], 
                    $data['cislo'], $data['rok'],  $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_projekt']);
        }

    public static function findByZajemce(Projektor2_Model_Db_Zajemce $zajemce) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM certifikat_projekt WHERE id_zajemce_FK = :id_zajemce_FK";
        $bindParams = array('id_zajemce_FK'=>$zajemce->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_CertifikatProjekt($data['id_zajemce_FK'], 
                    $data['cislo'], $data['rok'],  $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_projekt']);
    } 
    
    /**
     * Vytvoří novy záznam v databázi a zpětně ho načte do nového objektu Projektor2_Model_Certifikat. 
     * Číslo cerifikátu určí jako o jednotku vyšší než nejvyšší číslo již použité v daném roce. 
     * Rok určí automaticky z datutmu za daného parametrem $createDate. 
     * Každému záznamu v databázi metoda sama přidá položku db_host, která obsahuje název hostitele databáze, se kterou aplikace právě pracuje. 
     * Tato požka může sloužit k rozpoznání a odstranění záznamů vzniklých při testování, kdy obvykle db_host=localhost. 
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Date $date
     * @param string $fileName
     * @return Projektor2_Model_Db_CertifikatKurz
     */
    public static function create(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Date $date, $creator, $service, $fileName=NULL) {
        $rok = $date->dejRokRetezec();
        $appStatus = Projektor2_Model_SessionStatus::getSessionStatus();

        $dbh = Projektor2_AppContext::getDb(); 

        $query = "SELECT Max(cislo) AS maxCislo  FROM certifikat_projekt WHERE rok=:rok";  //vybírá i nevalidní
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

        $query = "INSERT INTO certifikat_projekt (id_zajemce_FK, cislo, rok, identifikator, filename, date, creator, service, db_host)
                  VALUES (:id_zajemce_FK, :cislo, :rok, :identifikator, :filename, :date, :creator, :service, :db_host)";  
        $bindParams = array('id_zajemce_FK'=>$zajemce->id,  
            'cislo'=>$cisloCertifikatu, 
            'rok'=>$rok, 
            'identifikator'=>  Projektor2_AppContext::getCertificateProjektIdentificator($rok, $cisloCertifikatu),
            'filename'=>$fileName, 
            'date'=>$date->dejDatumproSQL(), 
            'creator'=>$creator,
            'service'=>$service,            
            'db_host'=>$dbh->getDbHost());
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        // model vytvořen načtením z databáze
        return self::findById($dbh->lastInsertId());
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $sessionStatus = Projektor2_Model_SessionStatus::getSessionStatus();
        $query = "SELECT * FROM certifikat_projekt";
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        $bindParams = array();
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }  
        foreach($radky as $radek) {
            $vypis[] = new Projektor2_Model_Db_CertifikatProjekt($data['id_zajemce_FK'], 
                    $data['cislo'], $data['rok'],  $data['identifikator'], $data['filename'], $data['date'], 
                    $data['creating_time'], $data['creator'], $data['service'], $data['db_host'], $data['id_certifikat_projekt']);
        }

        return $vypis;
    }
    
    public static function update(Projektor2_Model_Db_CertifikatProjekt $projektCertifikat) {
        $dbh = Projektor2_AppContext::getDb(); 
        foreach ($projektCertifikat as $key => $value) {
            if ($key!='id' AND $key!='creating_time') {  // vyloučeny sloupce PRIMARY KEY a TIMESTAMP s DEFAULT hodnotou
                $set[] = $key.'=:'.$key;
                $bindParams[$key] = $value;
            }
        }
        
        $query = "UPDATE certifikat_projekt SET ".implode(', ', $set)." WHERE id_certifikat_projekt=:id_certifikat_projekt";  
        $bindParams['id_certifikat_projekt'] = $projektCertifikat->id;
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);  
        if ($succ) {
            return $projektCertifikat;
        } else {
            return NULL;
        }
    }
    
    public static function delete(Projektor2_Model_Db_CertifikatProjekt $projektCertifikat) {
        $dbh = Projektor2_AppContext::getDb(); 

        $query = "DELETE FROM certifikat_projekt WHERE id_certifikat_projekt=:id_certifikat_projekt";  
        $bindParams = array('id_certifikat_projekt'=>$projektCertifikat->id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);  
        if ($succ) {
            unset( $projektCertifikat);
        }
    }    
}

?>