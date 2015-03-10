<?php
/**
 * Description of SaveForm
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Ap_IP1 extends Projektor2_Controller_Formular_IP {
    
    protected function createFormModels($zajemce) {
         $this->models['plan'] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
         $this->models['dotaznik'] = new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
    
    protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Projektor2_AppContext::getAktivityProjektuTypu($this->sessionStatus->projekt->kod, 'kurz');
        $kurzyModelsAssoc = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Model_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->zajemce);
        
        $view = new Projektor2_View_HTML_Formular_IP1($this->sessionStatus, $this->createContextFromModels());    
        $view->assign('nadpis', 'INDIVIDUÁLNÍ PLÁN ÚČASTNÍKA PROJEKTU Alternativní práce')
            ->assign('formAction', 'ap_plan_uc')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)                
            ->assign('kurzyModels', $kurzyModelsAssoc)
            ->assign('kurzyPlan', $kurzyPlanAssoc)
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))                
            ->assign('submitTiskIP1', array('name'=>'pdf', 'value'=>'Tiskni IP 1.část'));
        return $view;
    }
    
    protected function getResultPdf() {        
        if ($this->request->post('pdf') == "Tiskni IP 1.část") {
            $kurzyPlan = Projektor2_Model_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->zajemce);           
            $view = new Projektor2_View_PDF_Ap_IP1($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast1_aktivity';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
                ->assign('kurzyPlan', $kurzyPlan);        
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $view->save($fileName);
            $htmlResult = $view->getNewWindowOpenerCode();                        
        }
        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) { 
            $indexAktivity = trim(substr($this->request->post('pdf'), strlen('Tiskni osvědčení')));  // druh je řetězec za slovy Tiskni osvědčení
            $kurzPlan = Projektor2_Model_AktivityPlanMapper::findByIndexAktivity($this->sessionStatus, $this->sessionStatus->zajemce, $indexAktivity);
            $params = array('idSKurzFK'=>$kurzPlan->sKurz->id, 'datumCertif' => $kurzPlan->datumCertif);
            
            $ctrlIpCertifikat = new Projektor2_Controller_Certifikat_Kurz($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();                   
        }
        return $htmlResult;
    }
}