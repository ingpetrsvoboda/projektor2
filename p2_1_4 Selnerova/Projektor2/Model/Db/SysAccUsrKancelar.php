<?php
class Projektor2_Model_Db_SysAccUsrKancelar {
    //tabulka c_kancelar
    public $id;
    public $id_sys_users;
    public $id_c_kancelar;
    
    public function __construct($id = false, $id_sys_users = false, $id_c_kancelar = false) {
        $this->id = $id;
        $this->id_sys_users = $id_sys_users;
        $this->id_c_kancelar = $id_c_kancelar;
    }
}

?>