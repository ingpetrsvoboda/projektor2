<?php
class Projektor2_Model_Db_SysAccUsrKancelarMapper {
    public static function findById($userId, $kancelarId) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM sys_acc_usr_kancelar
                    WHERE id_sys_users =:id_sys_users
                    AND id_c_kancelar =:id_c_kancelar";
        $bindParams = array('id_sys_users'=>$userId, 'id_c_kancelar'=>$kancelarId);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_SysAccUsrKancelar($data['id_sys_acc_usr_kancelar'],$data['id_sys_users'],$data['id_c_kancelar']);
    }
    
    public static function findAll($filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = "SELECT * FROM sys_acc_usr_kancelar";
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
            return array();
        }        
        foreach($radky as $radek) {
            $vypis[] = new Projektor2_Model_Db_SysAccUsrKancelar($data['id_sys_acc_usr_kancelar'],$data['id_sys_users'],$data['id_c_kancelar']);
        }
        return $vypis;        
    }      
    
    public static function getIndexArray($indexName, $filter = NULL, $order = NULL) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = "SELECT ".$indexName." FROM sys_acc_usr_kancelar";
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
            $pole[] = $radek[$indexName];
        }
        return $pole;          
    }
}

?>