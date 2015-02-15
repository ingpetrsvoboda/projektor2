<?php
class Projektor2_Model_Db_ZajemceCertifikatMapper {
    /**
     * Metoda vrací pole modelů Projektor2_Model_ZajemceCertifikaty
     * @param integer $id
     * @return \Projektor2_Model_Db_ZajemceCertifikat
     */
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "select 
        `certifikat_kurz`.`id_certifikat_kurz` AS `id_certifikat_kurz`,
        `certifikat_kurz`.`id_zajemce_FK` AS `id_zajemce_FK`,
        `certifikat_kurz`.`id_s_kurz_FK` AS `id_s_kurz_FK`,
        `certifikat_kurz`.`cislo` AS `cislo`,
        `certifikat_kurz`.`rok` AS `rok`,
        `certifikat_kurz`.`filename` AS `filename`,
        `certifikat_kurz`.`date` AS `date`,
        `certifikat_kurz`.`db_host` AS `db_host`,
        `s_kurz`.`id_s_kurz` AS `id_s_kurz`,
        `s_kurz`.`razeni` AS `razeni`,
        `s_kurz`.`projekt_kod` AS `projekt_kod`,
        `s_kurz`.`kancelar_kod` AS `kancelar_kod`,
        `s_kurz`.`kurz_druh` AS `kurz_druh`,
        `s_kurz`.`kurz_cislo` AS `kurz_cislo`,
        `s_kurz`.`beh_cislo` AS `beh_cislo`,
        `s_kurz`.`kurz_lokace` AS `kurz_lokace`,
        `s_kurz`.`kurz_zkratka` AS `kurz_zkratka`,
        `s_kurz`.`kurz_nazev` AS `kurz_nazev`,
        `s_kurz`.`pocet_hodin` AS `pocet_hodin`,
        `s_kurz`.`date_zacatek` AS `date_zacatek`,
        `s_kurz`.`date_konec` AS `date_konec`,
        `s_kurz`.`dodavatel` AS `dodavatel`,
        `s_kurz`.`valid` AS `valid`
             from (`certifikat_kurz` join `s_kurz` on((`certifikat_kurz`.`id_s_kurz_FK` = `s_kurz`.`id_s_kurz`)))
             where `id_zajemce_FK` = :id_zajemce_FK";
        
        $bindParams = array('id_zajemce_FK'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        foreach ($data as $radek) {
            $datetimeDate = Projektor2_Date::zSQL($radek['date']);
            if ($datetimeDate) {
                $date = $datetimeDate->dejDatumRetezec();                
            } else {
                $date = '';
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
            $vypis[] = new Projektor2_Model_Db_ZajemceCertifikat(
                    $radek['id_zajemce_FK'], $radek['id_s_kurz_FK'], $radek['cislo'], $radek['rok'], $radek['filename'], $date, $radek['db_host'], 
                    $radek['id_s_kurz'], $radek['razeni'], $radek['projekt_kod'], $radek['kancelar_kod'], $radek['kurz_druh'], $radek['kurz_cislo'], $radek['beh_cislo'], 
                    $radek['kurz_lokace'], $radek['kurz_zkratka'], $radek['kurz_nazev'], $radek['pocet_hodin'], $dateZacatek, $dateKonec, $radek['dodavatel'], $radek['valid'], 
                    $radek['id_certifikat_kurz']);  // poslední je id modelu
        }
        return $vypis;
    }
}

?>