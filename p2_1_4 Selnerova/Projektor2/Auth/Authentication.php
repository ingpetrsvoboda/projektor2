<?php
//require_once "DB.inc";

//class Authentication {
class Projektor2_Auth_Authentication {
    public static function check_credentials($name,$password) {
        $dbh = Projektor2_AppContext::getDb();
        $query = "SELECT authtype,id_sys_users FROM sys_users WHERE username=:username";
        $sth = $dbh->prepare($query);
        $succ = $sth->execute(array('username'=>$name));
        $data = $sth->fetch();
        if($data['authtype']!=NULL){
            switch ($data['authtype']){
                case "password":
                    $query = "SELECT id_sys_users FROM sys_users
                                WHERE username= :username
                                AND password =:password";
                    $sth = $dbh->prepare($query);
                    $succ = $sth->execute(array('username'=>$name, 'password'=>md5($password)));
                    $data = $sth->fetch();
                    if($data) {
                        return $data['id_sys_users'];
                    }
                    else {
                        return NULL;
                    }
            }
        }
    }
}
            
?>