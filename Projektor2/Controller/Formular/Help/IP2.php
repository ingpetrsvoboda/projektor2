<?php
/**
 * Description of Projektor2_Controller_Formular_Help_IP2
 *
 * @author pes2704
 */
class Projektor2_Controller_Formular_Help_IP2 extends Projektor2_Controller_Formular_IP {

    protected function createFormModels($zajemce) {
        $this->models['ukonceni'] = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce); 
        $this->models['plan']= new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce);
        $this->models['dotaznik']= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
    }
        
   protected function getResultFormular() {
        $aktivityProjektuTypuKurz = Projektor2_AppContext::getAktivityProjektuTypu($this->sessionStatus->projekt->kod, 'kurz');
        $kurzyModelsAssoc = $this->createDbSKurzModelsAssoc($aktivityProjektuTypuKurz);
        $kurzyPlanAssoc = Projektor2_Model_AktivityPlanMapper::findAllAssoc($this->sessionStatus, $this->sessionStatus->zajemce);
        
        $ukonceniArray = Projektor2_AppContext::getUkonceniProjektu($this->sessionStatus->projekt->kod);
                                           
        $view = new Projektor2_View_HTML_Formular_IP2($this->sessionStatus, $this->createContextFromModels());     
        $view->assign('nadpis', 'UKONČENÍ ÚČASTI V PROJEKTU A DOPLNĚNÍ IP - 2. část')
            ->assign('formAction', 'he_ukonceni_uc')
            ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)                
            ->assign('duvodUkonceniValuesArray', $ukonceniArray['duvod'])
            ->assign('duvodUkonceniHelpArray', $ukonceniArray['duvodHelp'])
            ->assign('s_certifikatem', $ukonceniArray['s_certifikatem'])
            ->assign('kurzyModels', $kurzyModelsAssoc)
            ->assign('kurzyPlan', $kurzyPlanAssoc)                
            ->assign('submitUloz', array('name'=>'save', 'value'=>'Uložit'))                
            ->assign('submitTiskIP2', array('name'=>'pdf', 'value'=>'Tiskni IP 2.část - vyhodnocení aktivit'))
            ->assign('submitTiskUkonceni', array('name'=>'pdf', 'value'=>'Tiskni ukončení účasti'));        
        return $view;
    }
    
    protected function getResultPdf() {
        if ($this->request->post('pdf') == "Tiskni IP 2.část - vyhodnocení aktivit") {
            $kurzyPlan = Projektor2_Model_AktivityPlanMapper::findAll($this->sessionStatus, $this->sessionStatus->zajemce);            
            $view = new Projektor2_View_PDF_Help_IP2($this->sessionStatus, $this->createContextFromModels());
            $file = 'IP_cast2';
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka)
//                ->assign('aktivityProjektuTypuKurz', $aktivityProjektuTypuKurz)
                ->assign('kurzyPlan', $kurzyPlan);        
//            $this->assignKurzyToPdfView($this->models['plan'], $view);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();                      
        }

        if ($this->request->post('pdf') == "Tiskni ukončení účasti") {
            $view = new Projektor2_View_PDF_Help_Ukonceni($this->sessionStatus, $this->createContextFromModels());
            $file = 'ukonceni';
            //status proměnné
            $view->assign('kancelar_plny_text', $this->sessionStatus->kancelar->plny_text)
                ->assign('user_name', $this->sessionStatus->user->name)
                ->assign('identifikator', $this->sessionStatus->zajemce->identifikator)
                ->assign('znacka', $this->sessionStatus->zajemce->znacka);
            $fileName = $this->createFileName($this->sessionStatus, $file);
            $view->assign('file', $fileName);

            $relativeFilePath = Projektor2_AppContext::getRelativeFilePath($this->sessionStatus->projekt->kod).$fileName;
            $view->save($relativeFilePath);
            $htmlResult = $view->getNewWindowOpenerCode();            
        }

        if (strpos($this->request->post('pdf'), 'Tiskni osvědčení') === 0 ) {
            $datumCertif = $this->models['ukonceni']->datum_certif;
            $params = array('datumCertif' => $datumCertif);
            $ctrlIpCertifikat = new Projektor2_Controller_xxx_Certifikat_Projekt($this->sessionStatus, $this->request, $this->response, $params);
            $htmlResult = $ctrlIpCertifikat->getResult();                      
        }       

        return $htmlResult;
    }
}

?>
