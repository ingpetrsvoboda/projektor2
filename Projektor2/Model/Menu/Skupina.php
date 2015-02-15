<?php
/**
 * Description 
 *
 * @author pes2704
 */
class Projektor2_Model_Menu_Skupina {
    public $menuTlacitka = array();
    public $menuSignaly = array();
    
    public function setMenuTlacitko($name, Projektor2_Model_Menu_Tlacitko $tlacitko) {
        $this->menuTlacitka[$name] = $tlacitko;
    }
    
    public function getMenuTlacitko($name) {
        return $this->menuTlacitka[$name];
    }
    
    public function getMenuTlacitkaAssoc() {
        return $this->menuTlacitka;
    }    
    
    public function setMenuSignal($name, Projektor2_Model_Menu_Signal $signal) {
        $this->menuSignaly[$name] = $signal;
    }
    
    public function getMenuSignal($name) {
        return $this->menuSignaly[$name];
    }
    
    public function getMenuSignalyAssoc() {
        return $this->menuSignaly;
    } 
    
 }
