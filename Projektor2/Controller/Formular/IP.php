<?php
/**
 * Description of Projektor2_Controller_Formular_HelpIP
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Formular_IP extends Projektor2_Controller_Formular_Base {
    
    /**
     * Metoda vrací pole objektů Projektor2_Model_SKurz pro aktuální projekt, běh, kancelář a zadaný druh kurzu. 
     * Metoda vytvoří filtr z kontextu aplikace 
     * (projekti, běh a kancelář) a druhu kurzu zadaného jako parametr. Do výběru přidá vždy i kurzy, 
     * kde kurz_zkratka='*'. S tímto filtrem pak volá Projektor2_Model_SKurzMapper, metodu findAll().
     * @param string $kurz_druh Parametr musí obsahovat hodnotu ze sloupce kurz_druh db tabulky s_kurz
     * @return array of Projektor2_Model_SKurz
     */
    protected function contextSelectKurz($kurz_druh, $default=TRUE) {
        $filter = "(projekt_kod='".$this->sessionStatus->projekt->kod
                ."' AND kancelar_kod='".$this->sessionStatus->kancelar->kod
                ."' AND beh_cislo='".$this->sessionStatus->beh->beh_cislo
                ."' AND kurz_druh='".$kurz_druh."')";
        if ($default) {
            $filter .= " OR kurz_zkratka='*'";
        }
        $filter = "(".$filter.")";
        $mapper = new Projektor2_Model_Db_SKurzMapper();
        return $mapper->findAll($filter, 'razeni');        
    }
    
    protected function createKurzyModels($kurzy) {
        $kurzyModels = array();
        foreach ($kurzy as $druhKurzu => $kurz) {
            $kurzyModels[$druhKurzu] = $this->contextSelectKurz($kurz['kurz_druh']);
        }
        return $kurzyModels;
    }   
       
    protected function createFileName(Projektor2_Model_SessionStatus $sessionStatus, $file) {
        return $sessionStatus->projekt->kod.'_'.$file.' '.$sessionStatus->zajemce->identifikator.'.pdf';
    }      
}
