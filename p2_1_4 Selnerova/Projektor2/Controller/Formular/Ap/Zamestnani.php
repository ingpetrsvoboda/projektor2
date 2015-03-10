<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_Zamestnani extends Projektor2_Controller_Formular_Base {
    

    protected function createFormModels($zajemce) {
        //$this->flatTable = new Projektor2_Model_Flat_ZaZamFlatTable($zajemce); 
        $this->models['zamestnani'] = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        //$pole = $this->flatTable->getValuesAssoc();
         
        $view = new Projektor2_View_HTML_Ap_Zamestnani($this->sessionStatus, $this->createContextFromModels());
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {

        
        return ;
    }

}

?>
