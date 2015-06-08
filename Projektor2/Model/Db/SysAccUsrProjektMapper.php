<?php
class Projektor2_Model_Db_SysAccUsrProjektMapper {
    public static function findById($userId, $projektId) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT * FROM sys_acc_usr_projekt
                    WHERE id_sys_users =:id_sys_users
                    AND id_c_projekt =:id_c_projekt";
        $bindParams = array('id_sys_users'=>$userId, 'id_c_projekt'=>$projektId);
        $sth = $dbh->prepare($query);
        $succ = $sth->execute($bindParams);
        $data = $sth->fetch(PDO::FETCH_ASSOC);  
        if(!$data) {
            return NULL;
        }
        return new Projektor2_Model_Db_SysAccUsrProjekt($data['id_sys_acc_usr_projekt'],$data['id_sys_users'],$data['id_c_projekt']);
    }
}

?>