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
class Projektor2_Controller_Formular_Help_Dotaznik extends Projektor2_Controller_Formular_Base {
    

    protected function createFormModels($zajemce) {
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce); 
    }
    
    protected function getResultFormular() {
        $htmlResult = "";
        $view = new Projektor2_View_HTML_Help_Dotaznik($this->sessionStatus, $this->createContextFromModels());
        $htmlResult .= $view->render();
        
        return $htmlResult;
    }
    
    protected function getResultPdf() {
        $html = '<div><img src="./img/loga/loga_HELP50+_BW.png"></div>';
        $view = new Projektor2_View_HTML2PDF_Dotaznik($this->sessionStatus);
        $html .= $this->getResultFormular();

        $view->assign('html', $html);        
//        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);

        $fileName = $this->sessionStatus->projekt->kod.'_'.'dotaznik'.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
        $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
        $view->save($relativeFilePath);
        $htmlResult .= $view->getNewWindowOpenerCode();
        
        return $htmlResult;
    }


}

?>
