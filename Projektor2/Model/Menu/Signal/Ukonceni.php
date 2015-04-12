<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Model_Menu_Signal_Ukonceni extends Projektor2_Model_Menu_Signal {
    
    public function setByUkonceni(Projektor2_Model_Db_Flat_ZaUkoncFlatTable $ukoncení, $ukonceniArray) {
        
        if ($ukoncení->datum_ukonceni){
            $duvod = $ukoncení->duvod_ukonceni;
            $this->text = substr($duvod, 0, strpos($duvod, ' '));
            if ($ukoncení->datum_certif) {  //ma certifikat projekt
                $this->status = 'uspesneSCertifikatem';
            } elseif ($ukoncení->dokonceno=='Ano' AND $ukonceniArray['s_certifikatem']) {
                $this->status = 'uspesneCekaNaCertifikat';                        
            } elseif ($ukoncení->dokonceno=='Ano' AND !$ukonceniArray['s_certifikatem']) {
                $this->status = 'uspesne';                        
            } elseif ($ukoncení->dokonceno=='Ne') {
                $this->status = 'neuspesne';                        
            } else {
                $this->status = 'none';
            }
        } else {
            $this->text = '.';
            $this->status = 'none';                                        
        }        
    }
}
