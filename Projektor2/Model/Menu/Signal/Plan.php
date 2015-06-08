<?php
/**
 * Description of Projektor2_Model_Menu_Signal_Plan
 *
 * @author pes2704
 */
class Projektor2_Model_Menu_Signal_Plan extends Projektor2_Model_Menu_Signal {
    
    public function setByAktivitaPlan(Projektor2_Model_AktivitaPlan $aktivitaPlan) {
        $sKurz = $aktivitaPlan->sKurz;
        if (isset($sKurz) AND $sKurz->isNaplanovan()){  //kurz je naplanovan
            $this->text = $aktivitaPlan->sKurz->kurz_druh;
            $this->kurzDruh = $aktivitaPlan->sKurz->kurz_druh;
            if ($aktivitaPlan->certifikatKurz) {  //ma certifikat kurz
                $this->status = 'uspesneSCertifikatem';
            } elseif ($aktivitaPlan->dokoncenoUspesne=='Ano' AND !$aktivitaPlan->aktivitaSCertifikatem) {
                $this->status = 'uspesne';                        
            } elseif ($aktivitaPlan->dokoncenoUspesne=='Ano' AND $aktivitaPlan->aktivitaSCertifikatem) {
                $this->status = 'uspesneCekaNaCertifikat';                        
            } elseif ($aktivitaPlan->dokoncenoUspesne=='Ne') {
                $this->status = 'neuspesne';                        
            } else {
                $this->status = 'plan';                    
            }
        } else {
            $this->text = '.';
            $this->status = 'none';                                        
        }        
    }
}
