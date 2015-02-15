<?php
class Projektor2_Model_Db_ZaPlanPoradenstvi extends Framework_Model_PersistableItem {
    //tabulka 'za_plan_poradenstvi';
    
    protected $id;
    protected $id_zajemce_FK;
    protected $id_s_kurz_FK;
    protected $text;
    protected $poc_abs_hodin;
    protected $duvod_absence;
    protected $dokonceno;
    protected $duvod_neukonceni;
    protected $valid;
    
}
