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
class Projektor2_Controller_Formular_Sjzp_Zamestnani extends Projektor2_Controller_Formular_Base {
    
    protected function createFormModels($zajemce) {
        $this->models['zamestnani'] = new Projektor2_Model_Db_Flat_ZaZamFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";         
        $view = new Projektor2_View_HTML_Sjzp_Zamestnani($this->createContextFromModels());
        $htmlResult .= $view->render();
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        return ;
    }

}

?>
