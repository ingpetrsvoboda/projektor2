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
class Projektor2_Controller_Formular_Help_IP1 extends Projektor2_Controller_Formular_IP {
    

    protected function createFormModels($zajemce) {
        $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
        $this->models['dotaznik'] = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
    
     protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Projektor2_AppContext::getAktivityProjektuTypu($this->sessionStatus->projekt->kod, 'kurz');
        $kurzyModels = $this->createKurzyModels($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Model_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->zajemce);
        
        $view = new Projektor2_View_HTML_Formular_IP1($this->sessionStatus, $this->createContextFromModels());    
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Help 50+')
            ->assign('formAction', 'he_plan_uc')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)                
            ->assign('kurzyModels', $kurzyModels)
            ->assign('kurzyPlan', $kurzyPlanAssoc)
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))                
            ->assign('submitTiskIP1', array('name'=>'pdf', 'value'=>'Tiskni IP 1.část'));
        return $view;
    }
     protected function getResultPdf() {
        
        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
//            $aktivityProjektuTypuKurz = Projektor2_AppContext::getAktivityProjektuTypuKurz($this->sessionStatus->projekt->kod);            
//            $kurzyModelsPlan = $this->createKurzyModelsByPlan($this->models['plan']);
            $kurzyPlan = Projektor2_Model_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->zajemce);
            
            $view = new Projektor2_View_PDF_Help_IP1($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast1_aktivity';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
//                ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)
                ->assign('kurzyPlan', $kurzyPlan);        
//            $this->assignKurzyToPdfView($this->models['plan'], $view);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $view->save($fileName);
            $htmlResult = $view->getNewWindowOpenerCode();                        
        }
        
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) { 
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení')));  // druh je řetězec za slovy Tiskni osvědčení
            $kurzPlan = Projektor2_Model_AktivityPlanMapper::findByIndexAktivity($this->sessionStatus, $this->sessionStatus->zajemce, $indexAktivity);
            $params = array('idSKurzFK'=>$kurzPlan->sKurz->id, 'datumCertif' => $kurzPlan->datumCertif);
            $ctrlIpCertifikat = new Projektor2_Controller_xxx_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();                   
        }
        return $htmlResult;
    }
    
//    
//    protected function getResultPdf() {
//        $view = new Projektor2_View_PDF_Help_IP1($this->createContextFromModels());
//        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
//            $view = new Projektor2_View_PDF_Ap_IP1($this->createContextFromModels());
//            $file = 'IP_cast1';
//        }
//        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) {
//            $aktivity = Projektor2_AppContext::getAktivityProjektu('AP');   
//            $druh = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení')));
//            $view = new Projektor2_View_PDF_Help_IPOsvedceni($this->createContextFromModels());
//            $view->assign('druh', $druh);
//            $file = 'IP_Osvedceni_'.$druh;
//        } 
//        
//        $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text);
//        $view->assign('user_name', $this->sessionStatus->user->name);
//        $view->assign('identifikator', $this->sessionStatus->zajemce->identifikator);
//        $this->assignKurzyToPdfView($this->models['plan'], $view);
//   
//        
//        $fileName = $this->sessionStatus->projekt->kod.'_'.$file.' '.$this->sessionStatus->zajemce->identifikator.'.pdf';
//        $view->assign('file', $fileName);
//        
//        $view->save($fileName);
//        $htmlResult .= $view->getNewWindowOpenerCode();
//        
//        return $htmlResult;
//    }
}

?>
