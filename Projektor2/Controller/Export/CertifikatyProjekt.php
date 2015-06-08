<?php
/**
 * Exportuje do pdf ("tiskne") všechny dosud nevyexportované certifikáty pro aktuální projekt
 *
 * @author pes2704
 */
class Projektor2_Controller_Export_CertifikatyProjekt extends Projektor2_Controller_Abstract { 
    
    /**
     * Metoda exportuje do pdf všechny dosud nevyexportované certifikáty o absolvování kurzu pro aktuální projekt.
     * Vytvoří a uloží pdf pro všechny kurzy (aktivity typu kurz), které jsou s certifikátem (aktivita s certifikátem) 
     * a které má zájemce v tabulce za_plan_flat_table zaznamenány jako dokončené úspěšně a se zadaným datem certifikátu, pokud již dříve nabyl 
     * takový certifikát vytvořen. To zjišťuje v db tabulce certifikaty_kurz.
     * @return type
     */
    public function getResult() {
        $zajemci = Projektor2_Model_Db_ZajemceMapper::findAllForProject();
        if ($zajemci) {
            ini_set('max_execution_time', Projektor2_AppContext::getExportCertifMaxExucutionTime());       
            $logger = Framework_Logger_File::getInstance('Logs', $this->sessionStatus->projekt->kod.' Exportovane certifikaty projekt '.date('Ymd_His'));
            foreach ($zajemci as $zajemce) {
                $ukonceni = new Projektor2_Model_Db_Flat_ZaUkoncFlatTable($zajemce); 
                if ($ukonceni->datum_certif) {
                    $datumCertifikatu = $ukonceni->datum_certif;  
                    $serviceCertifikat = new Projektor2_Service_CertifikatProjekt();
                    $certifikat = $serviceCertifikat->findByZajemce($zajemce);
                    if (!$certifikat) {

                        $certifikat = $serviceCertifikat->create($this->sessionStatus->projekt, 
                                            Projektor2_Model_Db_KancelarMapper::findById($zajemce->id_c_kancelar_FK), 
                                            $zajemce, $datumCertifikatu, $this->sessionStatus->user->username, __CLASS__);                        
                        if (!$certifikat) {
                            throw new LogicException('Nepodařilo se vytvořit certifikát pro zajemce id: '.$this->sessionStatus->zajemce->id. ', kurz id: '.$sKurz->id);
                        } 
                        $logger->log($certifikat->documentCertifikatProjekt->filePath);
                    }
                }
            }
        }
        $redirController = new Projektor2_Controller_ZobrazeniRegistraci($this->sessionStatus, $this->request, $this->response);
        return $redirController->getResult();
    }
}
