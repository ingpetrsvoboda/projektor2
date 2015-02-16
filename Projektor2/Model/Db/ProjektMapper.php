<?php
class Projektor2_Model_Db_ProjektMapper {
    public static function findById($id) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM c_projekt WHERE id_c_projekt = :id_c_projekt AND valid = 1";
        $bindParams = array('id_c_projekt'=>$id);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return new Projektor2_Model_Db_Projekt($data['id_c_projekt'],$data['kod'],$data['text'],$data['plny_text']);
    }

    public static function findByKod($kod) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM c_projekt WHERE kod = :kod AND valid = 1";
        $bindParams = array('kod'=>$kod);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return new Projektor2_Model_Db_Projekt($data['id_c_projekt'],$data['kod'],$data['text'],$data['plny_text']);
    }
    
    public static function findByText($text) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM c_projekt WHERE text = :text AND valid = 1";
        $bindParams = array('text'=>$text);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        return new Projektor2_Model_Db_Projekt($data['id_c_projekt'],$data['kod'],$data['text'],$data['plny_text']);
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = "SELECT * FROM c_projekt";
        if ($filter AND is_string($filter)) {
            $query .= " WHERE ".$filter;
        }
        if ($order AND is_string($order)) {
            $query .= " ORDER BY ".$order;
        }
        
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        $radky = $sth->fetchAll(PDO::FETCH_ASSOC);  
        if(!$radky) {
            return NULL;
        }        
        foreach($radky as $radek) {
            $vypis[] = new Projektor2_Model_Db_Projekt($data['id_c_projekt'],$data['kod'],$data['text'],$data['plny_text']);
        }
        return $vypis;        
    }    
}