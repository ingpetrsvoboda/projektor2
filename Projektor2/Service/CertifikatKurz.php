<?php
/**
 * Description of Projektor2_Model_CertifikatMapper
 *
 * @author pes2704
 */
class Projektor2_Service_CertifikatKurz {
    
    /**
     * 
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @return \Projektor2_Model_CertifikatKurz
     * @throws LogicException
     */
    public function findByZajemceKurz(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz) {
        $modelDbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::findByZajemceKurz($zajemce, $sKurz);
        if ($modelDbCertifikat) {
            $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzOriginalMapper::findByRelativeFilepath($modelDbCertifikat->filename);
            if (!isset($modelDocumentCertifikatOriginal)) {
                throw new LogicException('Nalezen certifikat v databázi '.print_r($modelDbCertifikat).' a nenalezen odpovídající soubor s pdf dokumentem. Certifikát id: '.$modelDbCertifikat->id.', filename: '.$modelDbCertifikat->filename);
            }
            // Obsah není třeba - čte se soubor přes javascriptový opener. Kdyby byl potřeba, tak třeba takto:
//            $modelCertifikatKurzDokument = Projektor2_Model_File_CertifikatKurzOriginalMapper::hydrate($modelDocumentCertifikatOriginal);        } else {
            $modelCertifikatKurz = new Projektor2_Model_CertifikatKurz($modelDbCertifikat, $modelDocumentCertifikatOriginal);
            return $modelCertifikatKurz;
        } else {
            return NULL;
        }

    }
    
    /**
     * 
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param type $datumCertifikatu
     * @param type $creator
     * @param type $service
     * @return \Projektor2_Model_CertifikatKurz
     * @throws RuntimeException
     */
    public function create(Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Kancelar $kancelar, 
                Projektor2_Model_Db_Zajemce $zajemce, Projektor2_Model_Db_SKurz $sKurz, $datumCertifikatu, $creator, $service) {
        $modelCertifikatKurz = $this->findByZajemceKurz($zajemce, $sKurz);
        if (!$modelCertifikatKurz) {
            assert($projekt->kod=='AP', 'Certifikáty pro jiný projekt než AP dosud nejsou implementovány!');

            // vytvoř db certifikát - zatím bez filename
            $datetimeCertifikatu = Projektor2_Date::zRetezce($datumCertifikatu);
            $modelDbCertifikat = Projektor2_Model_Db_CertifikatKurzMapper::create($zajemce, $sKurz, $datetimeCertifikatu, $creator, $service);  // bez filename
            // vytvoř a ulož pdf certifikátu
            $viewKurz = new Projektor2_View_PDF_Ap_KurzOsvedceniOriginal();
            $relativeOriginalDocumentPath = Projektor2_Model_File_CertifikatKurzOriginalMapper::getRelativeFilePath($projekt, $zajemce, $sKurz);
            $viewKurz = $this->completeKurzOsvedceniView($viewKurz, $projekt, $kancelar, $modelDbCertifikat, $sKurz, $relativeOriginalDocumentPath);            
            $content = $this->createContentCertifikatKurz($zajemce, $viewKurz);
            $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzOriginalMapper::create($projekt, $zajemce, $sKurz, $content);
            $modelDocumentCertifikatOriginal = Projektor2_Model_File_CertifikatKurzOriginalMapper::persist($modelDocumentCertifikatOriginal);            
            // vytvoř a ulož pdf pseudokopie
            $viewKurz = new Projektor2_View_PDF_Ap_KurzOsvedceniPseudokopie();
            $relativeOriginalDocumentPath = Projektor2_Model_File_CertifikatKurzPseudokopieMapper::getRelativeFilePath($projekt, $zajemce, $sKurz);
            $viewKurz = $this->completeKurzOsvedceniView($viewKurz, $projekt, $kancelar, $modelDbCertifikat, $sKurz, $relativeOriginalDocumentPath);            
            $content = $this->createContentCertifikatKurz($zajemce, $viewKurz);
            $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatKurzPseudokopieMapper::create($projekt, $zajemce, $sKurz, $content);
            $modelDocumentCertifikatPseudokopie = Projektor2_Model_File_CertifikatKurzPseudokopieMapper::persist($modelDocumentCertifikatPseudokopie);
            // vytvořen file model certifikát i pseudokopie -> nastav název souboru certifikátu v db
            if ($modelDocumentCertifikatOriginal AND $modelDocumentCertifikatPseudokopie) {
                $modelDbCertifikat->filename = $modelDocumentCertifikatOriginal->documentPath;            
                Projektor2_Model_Db_CertifikatKurzMapper::update($modelDbCertifikat);          
            } else {
                Projektor2_Model_Db_CertifikatKurzMapper::delete($modelDbCertifikat);  // nekontroluji smazání
                if (!$modelDocumentCertifikatOriginal) {
                    throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatOriginal->documentPath);                
                }
                if (!$modelDocumentCertifikatPseudokopie) {
                    throw new RuntimeException('Nepodařilo se uložit pdf certifikátu do souboru: '.$modelDocumentCertifikatPseudokopie->documentPath);                
                }
            }
            $modelCertifikatKurz = new Projektor2_Model_CertifikatKurz($modelDbCertifikat, $modelDocumentCertifikatOriginal);
        }
        return $modelCertifikatKurz;
    }
    
    /**
     * Vytvoří pdf soubor s certifikátem a file model certifikátu.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @param Projektor2_View_PDF_Common $pdfView
     * @param type $fileMapperClassName
     * @return Framework_Model_FileItemAbstract
     */
    private function createContentCertifikatKurz(Projektor2_Model_Db_Zajemce $zajemce, Projektor2_View_PDF_Common $pdfView) {
        $models = $this->createKurzOsvedceniModels($zajemce);
        $context = $this->createContextFromModels($models);
        $pdfView->appendContext($context);
//        $viewKurz->appendContext(array(Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK => $this->models[Projektor2_View_PDF_Ap_KurzOsvedceni::MODEL_DOTAZNIK]));
        $pdfView->appendContext(array($pdfView::MODEL_DOTAZNIK => $models[$pdfView::MODEL_DOTAZNIK]));
        $content = $pdfView->render();        
        return $content;
    }
    
    /**
     * Přidá zadanému view go konzextu pozřebné proměnné
     * @param type $view
     * @param Projektor2_Model_Db_Projekt $projekt
     * @param Projektor2_Model_Db_Kancelar $kancelar
     * @param Projektor2_Model_Db_CertifikatKurz $certifikat
     * @param Projektor2_Model_Db_SKurz $sKurz
     * @param type $docPath
     * @return type
     */
    private function completeKurzOsvedceniView($view, Projektor2_Model_Db_Projekt $projekt, Projektor2_Model_Db_Kancelar $kancelar, 
                Projektor2_Model_Db_CertifikatKurz $certifikat, Projektor2_Model_Db_SKurz $sKurz, $docPath) {
        $view->assign('managerName', Projektor2_AppContext::getCertificateSignName($projekt->kod))
            //TODO: natvrdo psát např. Plzeň - píše se kancelář, do které jsi přihlášen                            
            ->assign('kancelar_plny_text', $kancelar->plny_text)
            ->assign('certifikat', $certifikat)            
            ->assign('sKurz', $sKurz)
            ->assign('file', $docPath);
        return $view;
    }
    
    /**
     * Vztvoří a vrací pole db modelů potřebných pto view.
     * @param Projektor2_Model_Db_Zajemce $zajemce
     * @return \Projektor2_Model_Db_Flat_ZaFlatTable
     */
    protected function createKurzOsvedceniModels(Projektor2_Model_Db_Zajemce $zajemce) {
         $models[Projektor2_View_PDF_Ap_KurzOsvedceniOriginal::MODEL_PLAN] = new Projektor2_Model_Db_Flat_ZaPlanFlatTable($zajemce); 
         $models[Projektor2_View_PDF_Ap_KurzOsvedceniOriginal::MODEL_DOTAZNIK]= new Projektor2_Model_Db_Flat_ZaFlatTable($zajemce);
         return $models;
    }
    
    /**
     * Vytvoří a vrací pole context vygenerované z modelů obsažených v $tjis->models. Pole context má indexy ve formě 
     * 'index modelu'.'separator'.'název vlastnosti'. Např. pro model uložený jako $this->models['dotaznik'] a jeho vlastnost 'prijmeni' 
     * vznikne prvek pole context s indexem 'dotaznik->prijmeni' a hodnotou vlastnosti.
     * @return array
     */
    protected function createContextFromModels($models) {
        foreach ($models as $modelSign => $model) {
            $assoc = $model->getValuesAssoc();
            foreach ($assoc as $key => $value) {
                $context[$modelSign.Projektor2_Controller_Formular_Base::MODEL_SEPARATOR.$key] = $value;
            }
        }        
        return $context;
    }          
}