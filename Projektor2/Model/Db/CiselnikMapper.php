<?php
abstract class Projektor2_Model_Db_CiselnikMapperAbstract {
    /**
     * 
     * @param type $id
     * @param type $findInvalid
     * @param type $findOutOfContext
     * @return type
     */
    public static function findById($id, $findInvalid=FALSE) {
        $dbh = Projektor2_AppContext::getDb();
        $query = 'SELECT razeni, kod, text, plny_text, valid FROM '.static::TABLE.' WHERE id_'.static::TABLE.' = :id';
        $bindParams = array('id'=>$id); 
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
    public static function findAll($filter = NULL, $order = NULL, $findInvalid=FALSE) {
        $dbh = Projektor2_AppContext::getDb(); 
        $query = 'SELECT razeni, kod, text, plny_text, valid FROM '.static::TABLE;
        if (!$findInvalid) {
            $query .=  " AND valid = 1";
        }
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
    
    abstract protected static function createModel();
}

?>