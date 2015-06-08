<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Abstract
 *
 * @author pes2704
 */
abstract class Projektor2_Controller_Certifikat_Abstract  extends Projektor2_Controller_Abstract {   
    
   
    
    protected function createFormModels(Projektor2_Model_Db_Zajemce $zajemce) {
       
         $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
         $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
    
    protected function createContextFromModels() {
        foreach ($this->models as $modelSign => $model) {
            $assoc = $model->getValuesAssoc();
            foreach ($assoc as $key => $value) {
                $context[$modelSign.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$key] = $value;
            }
        }        
        return $context;
    }
    
    
    
}
