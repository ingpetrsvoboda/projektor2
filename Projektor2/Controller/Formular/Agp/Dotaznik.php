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
class Projektor2_Controller_Formular_Agp_Dotaznik extends Projektor2_Controller_Formular_Agp_Menus {
    

    protected function createFormModels($zajemce) {        
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {        
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Agp_Dotaznik($this->createContextFromModels());
        $htmlResult .= $view->render();        
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $html = '<div><img src="./img/loga/logo_agp_bw.png"></div>';
        $view = new Projektor2_View_HTML2PDF_Dotaznik();
        $html .= $this->getResultFormular();

        $view->assign('html', $html);        
//        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'dotaznik'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $view->save($fileName);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
        
    }

}

?>
