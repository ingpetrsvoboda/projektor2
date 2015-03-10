<?php
class Projektor2_Model_Db_SysAccUsrProjekt {
    //tabulka c_kancelar
    public $id;
    public $id_sys_users;
    public $id_c_projekt;
    
    public function __construct($id = false, $id_sys_users = false, $id_c_projekt = false) {
        $this->id = $id;
        $this->id_sys_users = $id_sys_users;
        $this->id_c_projekt = $id_c_projekt;
    }
}

?>