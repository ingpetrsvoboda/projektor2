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
class Projektor2_Controller_Formular_Ap_Souhlas extends Projektor2_Controller_Formular_Base {
    

    protected function createFormModels($zajemce) {
        $this->models['smlouva'] = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        //$pole = $this->flatTable->getValuesAssoc();
        $view = new Projektor2_View_HTML_Ap_Souhlas ($this->createContextFromModels());
    
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $view = new Projektor2_View_PDF_Ap_Souhlas($this->createContextFromModels());
        
        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
        $view->assign('user_name', $this->sessionStatus->user->name);
        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
        $view->assign('znacka', $this->sessionStatus->zajemce->znacka);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'souhlas'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $view->assign('file', $fileName);
        
        $view->save($fileName);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }

}

?>
